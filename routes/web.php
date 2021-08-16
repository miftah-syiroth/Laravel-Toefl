<?php

use App\Http\Controllers\KelasController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ToeflController;
use App\Http\Controllers\UserController;
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
    return view('guest.home');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

// Route::get('/home', [PageController::class, 'home']);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::prefix('/participant')->group(function () {
        
        Route::get('/kelas/{kelas}/register', [UserController::class, 'kelasRegister'])->middleware(['role:participant', 'permission:registrasi kelas']); 
        Route::patch('/kelas/{kelas}/register', [UserController::class, 'storeKelasRegister'])->middleware(['role:participant', 'permission:registrasi kelas']);

        Route::get('/participants', [ParticipantController::class, 'index'])->name('participants.index');

        Route::get('/dashboard', function () {
            return view('participant.dashboard');
        })->name('participant.dashboard');
    });
    
    Route::prefix('/admin')->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // routing toefls
        Route::get('/toefls', [ToeflController::class, 'index'])->name('toefls.index');
        Route::get('/toefls/create', [ToeflController::class, 'create'])->name('toefls.create');
        Route::post('/toefls', [ToeflController::class, 'store'])->name('toefls.store');
        Route::get('toefls/{toefl}', [ToeflController::class, 'show'])->name('toefls.show');
        Route::get('/toefls/{toefl}/edit', [ToeflController::class, 'edit'])->name('toefls.edit');
        Route::put('/toefls/{toefl}', [ToeflController::class, 'update'])->name('toefls.update');
        Route::delete('/toefls/{toefl}', [ToeflController::class, 'destroy'])->name('toefls.destroy');
    
        // routing mengelola suatu toefl question
        Route::get('/toefls/{toefl}/sections/{section}/questions/create', [QuestionController::class, 'create']);
    
        // routing untuk kelola kelas
        Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
        Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
        Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
        Route::get('/kelas/{kelas}', [KelasController::class, 'show'])->name('kelas.show');
        Route::get('/kelas/{kelas}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
        Route::put('/kelas/{kelas}', [KelasController::class, 'update'])->name('kelas.update');
        Route::delete('/kelas/{kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy');
    });

});



