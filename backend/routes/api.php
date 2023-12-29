<?php


use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
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

Route::middleware('auth:sanctum')->group(function () {
  Route::get('/user', function (Request $request) {
      return $request->user();
  });

  Route::get('/categories', [CategoryController::class, 'index']);

  Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/category/create', [CategoryController::class, 'store']);
Route::post('/category/{id}/edit', [CategoryController::class, 'update']);
Route::post('/category/{id}/delete', [CategoryController::class, 'destroy']);

Route::get('/books', [BookController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
