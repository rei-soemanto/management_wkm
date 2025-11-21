<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- Internal Operations Controllers ---
use App\Http\Controllers\ManagementProjectController;
use App\Http\Controllers\ManagementProjectProgressController;
use App\Http\Controllers\ProjectTeamController;
use App\Http\Controllers\ProjectAllocationController;
use App\Http\Controllers\ProductInventoryController;

// --- Admin / Master Data Controllers ---
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Auth::routes();

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// =========================================================================
//  AUTHENTICATED ROUTES
// =========================================================================
Route::middleware(['auth'])->group(function () {

    // =======================================
    // 1. INTERNAL OPERATIONS (Projects & Ops)
    // =======================================
    
    // Projects (Dashboard, Create, Edit, Delete)
    Route::resource('projects', ManagementProjectController::class);
    
    // Project Progress Reporting (Uploads)
    Route::post('projects/{id}/progress', [ManagementProjectProgressController::class, 'store'])
        ->name('projects.progress.store');

    // Project Team Assignment (Add/Remove Members)
    Route::get('projects/{id}/team/create', [ProjectTeamController::class, 'create'])->name('projects.team.create');
    Route::post('projects/{id}/team', [ProjectTeamController::class, 'store'])->name('projects.team.store');
    Route::delete('projects/{id}/team/{assignmentId}', [ProjectTeamController::class, 'destroy'])->name('projects.team.destroy');

    // Project Inventory Allocation (BOM)
    Route::get('projects/{id}/allocation/create', [ProjectAllocationController::class, 'create'])->name('projects.allocation.create');
    Route::post('projects/{id}/allocation', [ProjectAllocationController::class, 'store'])->name('projects.allocation.store');
    Route::delete('projects/{id}/allocation/{usageId}', [ProjectAllocationController::class, 'destroy'])->name('projects.allocation.destroy');

    // Inventory (Stock Management)
    Route::get('/inventory', [ProductInventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/{id}/edit', [ProductInventoryController::class, 'edit'])->name('inventory.edit'); // Added Edit Route
    Route::post('/inventory/{id}', [ProductInventoryController::class, 'update'])->name('inventory.update');


    // =======================================
    // 2. ADMIN PANEL (Master Data & Public Site)
    // =======================================
    // Ideally, add 'admin' middleware here for extra security
    Route::prefix('admin')->group(function () {
        
        // Main Dashboard
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Client Management (New)
        Route::resource('clients', ClientController::class);

        // User Interests
        Route::get('/users', [AdminController::class, 'listUsers'])->name('admin.users.list');

        // --- Public Site Master Data ---
        
        // Products
        Route::prefix('products')->name('admin.products.')->group(function () {
            Route::get('/', [AdminController::class, 'listProducts'])->name('list');
            Route::get('/create', [AdminController::class, 'createProduct'])->name('create');
            Route::post('/', [AdminController::class, 'storeProduct'])->name('store');
            Route::get('/{id}/edit', [AdminController::class, 'editProduct'])->name('edit');
            Route::put('/{id}', [AdminController::class, 'updateProduct'])->name('update');
            Route::delete('/{id}', [AdminController::class, 'destroyProduct'])->name('destroy');
        });

        // Services
        Route::prefix('services')->name('admin.services.')->group(function () {
            Route::get('/', [AdminController::class, 'listServices'])->name('list');
            Route::get('/create', [AdminController::class, 'createService'])->name('create');
            Route::post('/', [AdminController::class, 'storeService'])->name('store');
            Route::get('/{id}/edit', [AdminController::class, 'editService'])->name('edit');
            Route::put('/{id}', [AdminController::class, 'updateService'])->name('update');
            Route::delete('/{id}', [AdminController::class, 'destroyService'])->name('destroy');
        });

        // Public Portfolio Projects (Gallery & Marketing)
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

// Utility Route for Storage Link (Run once if needed)
Route::get('/storage-link', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return 'Storage link created successfully!';
    } catch (\Exception $e) {
        return 'Error creating storage link: ' . $e->getMessage();
    }
});