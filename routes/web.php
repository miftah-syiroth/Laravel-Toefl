<?php

use App\Http\Controllers\ToeflController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::prefix('/admin')->group(function () {
    Route::get('/toefls', [ToeflController::class, 'index'])->name('toefl.index');
    Route::get('/toefls/create', [ToeflController::class, 'create'])->name('toefl.create');
    Route::post('/toefls', [ToeflController::class, 'store'])->name('toefl.store');
    Route::get('toefls/{toefl}', [ToeflController::class, 'show'])->name('toefl.show');
    Route::get('/toefls/{toefl}/edit', [ToeflController::class, 'edit'])->name('toefl.edit');
    Route::put('/toefls/{toefl}', [ToeflController::class, 'update'])->name('toefl.update');
    Route::delete('/toefls/{toefl}', [ToeflController::class, 'destroy'])->name('toefl.destroy');
});
