<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Core user
        User::firstOrCreate(['email' => 'core@kantin.com'], [
            'name'     => 'Admin Core',
            'password' => Hash::make('core123'),
            'role'     => 'super_admin',
        ]);

        // Admin user
        User::firstOrCreate(['email' => 'admin@kantin.com'], [
            'name'     => 'Admin Kantin',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // Demo regular user
        User::firstOrCreate(['email' => 'user@kantin.com'], [
            'name'     => 'Demo User',
            'password' => Hash::make('user1234'),
            'role'     => 'user',
        ]);

        // Sample menus
        $menus = [
            ['name' => 'Nasi Ayam Goreng',   'price' => 15000, 'category' => 'Makanan', 'description' => 'Nasi putih dengan ayam goreng crispy dan lalapan segar.'],
            ['name' => 'Nasi Rendang',        'price' => 18000, 'category' => 'Makanan', 'description' => 'Nasi putih dengan rendang daging sapi bumbu rempah.'],
            ['name' => 'Mie Goreng Spesial',  'price' => 13000, 'category' => 'Makanan', 'description' => 'Mie goreng dengan telur, sayuran, dan bakso.'],
            ['name' => 'Ayam Bakar',          'price' => 17000, 'category' => 'Makanan', 'description' => 'Ayam bakar bumbu kecap dengan sambal dan lalapan.'],
            ['name' => 'Es Teh Manis',        'price' => 5000,  'category' => 'Minuman', 'description' => 'Teh manis segar dengan es batu.'],
            ['name' => 'Jus Jeruk Segar',     'price' => 8000,  'category' => 'Minuman', 'description' => 'Jus jeruk segar tanpa pengawet.'],
        ];

        foreach ($menus as $menu) {
            Menu::firstOrCreate(['name' => $menu['name']], array_merge($menu, ['status' => 'available']));
        }
    }
}
