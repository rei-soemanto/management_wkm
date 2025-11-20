<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Internal Ops Controllers
use App\Http\Controllers\ManagementProjectController;
use App\Http\Controllers\ManagementProjectProgressController;
use App\Http\Controllers\ProductInventoryController;

// Public Site Control (Admin)
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// =========================================================================
//  AUTHENTICATED ROUTES
// =========================================================================
Route::middleware(['auth'])->group(function () {

    // --- 1. INTERNAL OPERATIONS (New Management System) ---
    
    // Dashboard / Projects List
    Route::resource('projects', ManagementProjectController::class);
    
    // Project Progress Reporting
    Route::post('projects/{id}/progress', [ManagementProjectProgressController::class, 'store'])
        ->name('projects.progress.store');

    // Product Inventory (Stock)
    Route::get('/inventory', [ProductInventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory/{id}', [ProductInventoryController::class, 'update'])->name('inventory.update');


    // --- 2. ADMIN PANEL (Controls Public Website Data) ---
    // Only for 'Admin' role (You might want to add a custom middleware here)
    Route::prefix('admin')->group(function () {

        // Dashboard
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // User Interests
        Route::get('/users', [AdminController::class, 'listUsers'])->name('admin.users.list');

        // Products (Master Data)
        Route::prefix('products')->name('admin.products.')->group(function () {
            Route::get('/', [AdminController::class, 'listProducts'])->name('list');
            Route::get('/create', [AdminController::class, 'createProduct'])->name('create');
            Route::post('/', [AdminController::class, 'storeProduct'])->name('store');
            Route::get('/{id}/edit', [AdminController::class, 'editProduct'])->name('edit');
            Route::put('/{id}', [AdminController::class, 'updateProduct'])->name('update');
            Route::delete('/{id}', [AdminController::class, 'destroyProduct'])->name('destroy');
        });

        // Services (Master Data)
        Route::prefix('services')->name('admin.services.')->group(function () {
            Route::get('/', [AdminController::class, 'listServices'])->name('list');
            Route::get('/create', [AdminController::class, 'createService'])->name('create');
            Route::post('/', [AdminController::class, 'storeService'])->name('store');
            Route::get('/{id}/edit', [AdminController::class, 'editService'])->name('edit');
            Route::put('/{id}', [AdminController::class, 'updateService'])->name('update');
            Route::delete('/{id}', [AdminController::class, 'destroyService'])->name('destroy');
        });

        // Public Projects (Gallery & Marketing Data)
        Route::prefix('public-projects')->name('admin.projects.')->group(function () {
            Route::get('/', [AdminController::class, 'listProjects'])->name('list');
            Route::get('/create', [AdminController::class, 'createProject'])->name('create');
            Route::post('/', [AdminController::class, 'storeProject'])->name('store');
            Route::get('/{id}/edit', [AdminController::class, 'editProject'])->name('edit');
            Route::put('/{id}', [AdminController::class, 'updateProject'])->name('update');
            Route::delete('/{id}', [AdminController::class, 'destroyProject'])->name('destroy');
        });
    });

});

// Utility Route for Storage Link
Route::get('/storage-link', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return 'Storage link created successfully!';
    } catch (\Exception $e) {
        return 'Error creating storage link: ' . $e->getMessage();
    }
});