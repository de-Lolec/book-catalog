<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\AuthController;

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

  Route::prefix('category')->group(function () {
    Route::post('/create', [CategoryController::class, 'store']);
    Route::post('/{id}/edit', [CategoryController::class, 'update']);
    Route::post('/{id}/delete', [CategoryController::class, 'destroy']);
  });

  Route::prefix('book')->group(function () {
      Route::post('/create', [BookController::class, 'store']);
      Route::post('/{id}/edit', [BookController::class, 'update']);
      Route::post('/{id}/delete', [BookController::class, 'destroy']);
  });

  Route::prefix('authors')->group(function () {
      Route::post('/create', [AuthorController::class, 'store']);
      Route::post('/{id}/edit', [AuthorController::class, 'update']);
      Route::post('/{id}/delete', [AuthorController::class, 'destroy']);
  });

  Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/books', [BookController::class, 'index']);
Route::get('/book/{id}', [BookController::class, 'show']);

Route::get('/authors', [AuthorController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
