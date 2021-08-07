<?php

use App\Http\Controllers\QuestionController;
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
    // routing toefls
    Route::get('/toefls', [ToeflController::class, 'index'])->name('toefls.index');
    Route::get('/toefls/create', [ToeflController::class, 'create'])->name('toefls.create');
    Route::post('/toefls', [ToeflController::class, 'store'])->name('toefls.store');
    Route::get('toefls/{toefl}', [ToeflController::class, 'show'])->name('toefls.show');
    Route::get('/toefls/{toefl}/edit', [ToeflController::class, 'edit'])->name('toefls.edit');
    Route::put('/toefls/{toefl}', [ToeflController::class, 'update'])->name('toefls.update');
    Route::delete('/toefls/{toefl}', [ToeflController::class, 'destroy'])->name('toefls.destroy');

    // routing question
    Route::get('/toefls/{toefl}/sections/{section}/questions/create', [QuestionController::class, 'create']);
});
