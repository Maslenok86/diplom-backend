<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\Auth\RegistrationController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\TaskStatusController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/registration', [RegistrationController::class, 'registration'])->name('registration');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::resources([
        'companies' => CompanyController::class,
        'companies.departments' => DepartmentController::class,
        'companies.tasks' => TaskController::class,
        'admins' => AdminController::class,
        'task-statuses' => TaskStatusController::class,
    ]);
    Route::get('/companies/{company}/get-users', [CompanyController::class, 'getUsers'])->name('companies.getUsers');
    Route::get('/get-employees-tasks', [TaskStatusController::class, 'getEmployeesTasks'])->name('employees.getTasks');
    Route::get('/get-admins-tasks', [TaskStatusController::class, 'getAdminsTasks'])->name('admins.getTasks');
});
