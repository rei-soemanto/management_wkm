<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ManagementProjectController;
use App\Http\Controllers\ManagementProjectProgressController;
use App\Http\Controllers\ProjectTeamController;
use App\Http\Controllers\ProjectAllocationController;
use App\Http\Controllers\ProductInventoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectTaskController;
use App\Http\Controllers\Admin\UserManagementController;

use App\Http\Middleware\CheckAdminRole;
use App\Http\Middleware\CheckManagerRole;
use App\Http\Middleware\CheckProjectAccess;

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth','internal'])->group(function () {

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users', [UserController::class, 'destroy'])->name('users.destroy');

    Route::middleware([CheckProjectAccess::class])->group(function () {

        Route::resource('projects', ManagementProjectController::class);
        
        Route::post('projects/{id}/progress', [ManagementProjectProgressController::class, 'store'])->name('projects.progress.store');
    });

    Route::middleware([CheckManagerRole::class])->group(function () {

        Route::get('/inventory', [ProductInventoryController::class, 'index'])->name('inventory.index');

        Route::get('admin/users', [AdminController::class, 'listUsers'])->name('admin.users.list');
    });

    Route::middleware([CheckAdminRole::class])->group(function () {

        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        Route::get('/user_manage', [UserManagementController::class, 'index'])->name('admin.user_manage.list');
        Route::get('/user_manage/{id}/edit', [UserManagementController::class, 'edit'])->name('admin.user_manage.edit');
        Route::put('/user_manage/{id}', [UserManagementController::class, 'update'])->name('admin.user_manage.update');
        
        Route::resource('clients', ClientController::class);

        Route::get('/inventory/{id}/edit', [ProductInventoryController::class, 'edit'])->name('inventory.edit');
        Route::post('/inventory/{id}', [ProductInventoryController::class, 'update'])->name('inventory.update');

        Route::prefix('projects')->name('projects.')->group(function () {
            Route::get('/{id}/team/create', [ProjectTeamController::class, 'create'])->name('team.create');
            Route::post('/{id}/team', [ProjectTeamController::class, 'store'])->name('team.store');
            Route::delete('/{id}/team/{assignmentId}', [ProjectTeamController::class, 'destroy'])->name('team.destroy');

            Route::post('/{projectId}/tasks', [ProjectTaskController::class, 'store'])->name('tasks.store');
            Route::get('/{projectId}/tasks/{taskId}/edit', [ProjectTaskController::class, 'edit'])->name('tasks.edit');
            Route::patch('/{projectId}/tasks/{taskId}', [ProjectTaskController::class, 'update'])->name('tasks.update');
            Route::delete('/{projectId}/tasks/{taskId}', [ProjectTaskController::class, 'destroy'])->name('tasks.destroy');

            Route::get('/{id}/allocation/create', [ProjectAllocationController::class, 'create'])->name('allocation.create');
            Route::post('/{id}/allocation', [ProjectAllocationController::class, 'store'])->name('allocation.store');
            Route::put('/{id}/allocation/{usage_id}', [ProjectAllocationController::class, 'update'])->name('allocation.update');
            Route::delete('/{id}/allocation/{usageId}', [ProjectAllocationController::class, 'destroy'])->name('allocation.destroy');
        });

        Route::prefix('products')->name('admin.products.')->group(function () {
            Route::get('/', [AdminController::class, 'listProducts'])->name('list');
            Route::get('/create', [AdminController::class, 'createProduct'])->name('create');
            Route::post('/', [AdminController::class, 'storeProduct'])->name('store');
            Route::get('/{id}/edit', [AdminController::class, 'editProduct'])->name('edit');
            Route::put('/{id}', [AdminController::class, 'updateProduct'])->name('update');
            Route::delete('/{id}', [AdminController::class, 'destroyProduct'])->name('destroy');
        });

        Route::prefix('services')->name('admin.services.')->group(function () {
            Route::get('/', [AdminController::class, 'listServices'])->name('list');
            Route::get('/create', [AdminController::class, 'createService'])->name('create');
            Route::post('/', [AdminController::class, 'storeService'])->name('store');
            Route::get('/{id}/edit', [AdminController::class, 'editService'])->name('edit');
            Route::put('/{id}', [AdminController::class, 'updateService'])->name('update');
            Route::delete('/{id}', [AdminController::class, 'destroyService'])->name('destroy');
        });

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