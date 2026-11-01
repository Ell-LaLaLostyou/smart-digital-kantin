<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Canteen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('canteen')
            ->orderByRaw("FIELD(role, 'super_admin', 'admin', 'user')")
            ->orderBy('name')
            ->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $canteens = Canteen::all();
        $roles = ['user' => 'Regular User / Student', 'admin' => 'Canteen Admin', 'super_admin' => 'Core Admin'];
        return view('admin.users.create', compact('canteens', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['user', 'admin', 'super_admin'])],
            'canteen_id' => 'nullable|exists:canteens,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'canteen_id' => $request->canteen_id,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $canteens = Canteen::all();
        $roles = ['user' => 'Regular User / Student', 'admin' => 'Canteen Admin', 'super_admin' => 'Core Admin'];
        return view('admin.users.edit', compact('user', 'canteens', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in(['user', 'admin', 'super_admin'])],
            'canteen_id' => 'nullable|exists:canteens,id',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'canteen_id' => $request->canteen_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
