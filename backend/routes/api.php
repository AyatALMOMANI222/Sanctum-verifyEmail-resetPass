<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Laravel\Sanctum\Sanctum;



use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');



Route::post('/users', [UserController::class, 'store']);


Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');


// Restu
Route::post('/restaurant', action: [RestaurantController::class, 'store'])->middleware(['auth:sanctum','admin']);
Route::get('/restaurant/{id}', [RestaurantController::class, 'getRestInfo']);


Route::post('/branch', action: [BranchController::class, 'store'])->middleware(['auth:sanctum','admin']);
Route::get('/branch', action: [BranchController::class, 'getBranches']);

// cat
Route::post('/cat', action: [CategoryController::class, 'store'])->middleware(['auth:sanctum','admin']);
Route::get(uri: '/cat', action: [CategoryController::class, 'getAllCategoriesWithBranches']);

// item
Route::post('/item', action: [ItemController::class, 'store'])->middleware(['auth:sanctum','admin']);
Route::get('/item', action: [ItemController::class, 'getItemsByBranchCategory']);
