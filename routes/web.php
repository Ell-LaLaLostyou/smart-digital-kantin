<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductionController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\FoodWasteController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\SimulationController;
use App\Http\Controllers\Admin\DSSController;
use App\Http\Controllers\User\PreorderController;
use App\Http\Controllers\DashboardController;

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');

Route::get('/canteen/{canteen:slug}', [App\Http\Controllers\WelcomeController::class, 'showCanteen'])->name('canteen.show');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/preorders', [PreorderController::class, 'store'])->name('preorders.store');
Route::get('/preorders/receipt/{order_number}', [PreorderController::class, 'receipt'])->name('preorders.receipt');
Route::post('/preorders/receipt/{order_number}/upload', [PreorderController::class, 'uploadProof'])->name('preorders.upload_proof');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Routes
    Route::get('/preorders', [PreorderController::class, 'index'])->name('preorders.index');
    Route::get('/preorders/create', [PreorderController::class, 'create'])->name('preorders.create');
    // store is moved outside to allow guest
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('menus', MenuController::class);
    Route::resource('productions', ProductionController::class);
    Route::resource('sales', SaleController::class);
    Route::resource('food-wastes', FoodWasteController::class);
    Route::post('food-wastes/{food_waste}/donate', [FoodWasteController::class, 'donate'])->name('food-wastes.donate');
    Route::resource('donations', DonationController::class);
    Route::resource('simulations', SimulationController::class);
    Route::get('dss', [DSSController::class, 'index'])->name('dss.index');
    Route::post('dss/calculate', [DSSController::class, 'calculate'])->name('dss.calculate');
    
    // Preorders
    Route::get('/preorders', [App\Http\Controllers\Admin\AdminPreorderController::class, 'index'])->name('preorders.index');
    Route::patch('/preorders/{preorder}/status', [App\Http\Controllers\Admin\AdminPreorderController::class, 'updateStatus'])->name('preorders.status');
    Route::patch('/preorders/{preorder}/verify-payment', [App\Http\Controllers\Admin\AdminPreorderController::class, 'verifyPayment'])->name('preorders.verify_payment');
    
    // Reports
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/download', [App\Http\Controllers\Admin\ReportController::class, 'downloadPdf'])->name('reports.download');
    
    // Eco Impact
    Route::get('/eco-impact', [App\Http\Controllers\Admin\EcoController::class, 'index'])->name('eco.index');
});

require __DIR__.'/auth.php';
