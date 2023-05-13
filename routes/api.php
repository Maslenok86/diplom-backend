<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\Auth\RegistrationController;
use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/roles', [RoleController::class, 'create'])->name('createRole');
Route::get('/get-role', [UserController::class, 'getRole'])->name('getRole');
Route::post('/registration', [RegistrationController::class, 'registration'])->name('registration');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::resources([
    'companies' => CompanyController::class,
    'companies.departments' => DepartmentController::class,
]);

