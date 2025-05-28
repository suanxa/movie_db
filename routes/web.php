<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Categories;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [MovieController::class, 'index'])->name('movies.index');

Route::get('/search', [MovieController::class, 'search'])->name('movies.search');

Route::get('/movie/{id}/{slug}', [MovieController::class, 'detail_movie'])->name('movies.detail_movie');

// resource route untuk movies (plural)
// Route::resource('movies', MovieController::class)->middleware('auth');
Route::get('movies/create', [MovieController::class, 'create'])->name('movies.create')->middleware('auth');
Route::post('movies/store', [MovieController::class, 'store'])->name('movies.store')->middleware('auth');

Route::get('/login', [AuthController::class, 'formLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/movie/edit', [MovieController::class, 'editPage'])->name('movies.editPage')->middleware('auth');
Route::get('/movie/{id}/edit', [MovieController::class, 'edit'])->name('movie.edit')->middleware('auth');

Route::get('/editmovie/{id}', [MovieController::class, 'editMovie'])->name('movies.editmovie')->middleware('auth');

// Route::delete('/movie/{id}', [MovieController::class, 'destroy'])->name('movies.destroy')->middleware('auth');
Route::delete('/movie/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy');
Route::put('movie/{movie}', [MovieController::class, 'update'])->name('movies.update')->middleware('auth');





