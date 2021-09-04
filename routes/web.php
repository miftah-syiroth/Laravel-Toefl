<?php

use App\Http\Controllers\KelasController;
use App\Http\Controllers\ToeflController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Kelas\KelasIndex;
use App\Http\Livewire\Participant\ParticipantIndex;
use App\Http\Livewire\Participant\ShowParticipant;
use App\Http\Livewire\Question\CreateSection1;
use App\Http\Livewire\Question\CreateSection2;
use App\Http\Livewire\Question\CreateSection3;
use App\Http\Livewire\Toefl\ToeflIndex;
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

Route::view('/', 'guest.home');

Route::get('/participant/{kelas}/register', [UserController::class, 'participantRegister']);
Route::post('/participant/{kelas}', [UserController::class, 'storeParticipantRegister']);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::prefix('/participant')->middleware(['role:participant'])->group(function () {

        Route::view('/dashboard', 'participant.dashboard')->name('participant.dashboard');

        Route::group(['middleware' => ['permission:do toefl']], function () {
            Route::get('/toefls/listening-comprehension', [ToeflController::class, 'section1Exam']);
            Route::get('/toefls/structure-and-written-expression', [ToeflController::class, 'section2Exam']);
            Route::get('/toefls/reading-comprehension', [ToeflController::class, 'section3Exam']);
        });
    });
    
    Route::prefix('/admin')->middleware(['role:admin'])->group(function () {

        Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');

        // routing toefls
        Route::get('/toefls', ToeflIndex::class)->name('toefls.index'); // pakai livewire single page
        Route::get('/toefls/create', [ToeflController::class, 'create'])->name('toefls.create');
        Route::post('/toefls', [ToeflController::class, 'store'])->name('toefls.store');
        Route::get('toefls/{toefl}', [ToeflController::class, 'show'])->name('toefls.show');
        Route::get('/toefls/{toefl}/edit', [ToeflController::class, 'edit'])->name('toefls.edit');
        Route::put('/toefls/{toefl}', [ToeflController::class, 'update'])->name('toefls.update');
        Route::delete('/toefls/{toefl}', [ToeflController::class, 'destroy'])->name('toefls.destroy');
    
        // routing mengelola suatu toefl question
        // Route::get('/toefls/{toefl}/sections/{section}/questions/create', [QuestionController::class, 'create']);
        Route::get('/toefls/{toefl}/sections/1/questions/create', CreateSection1::class); //utk sections 1
        Route::get('/toefls/{toefl}/sections/2/questions/create', CreateSection2::class); //utk sections 2
        Route::get('/toefls/{toefl}/sections/3/questions/create', CreateSection3::class); //utk sections 3
        
        // routing untuk kelola kelas
        Route::get('/kelas', KelasIndex::class)->name('kelas.index');
        Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
        Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
        Route::get('/kelas/{kelas}', [KelasController::class, 'show'])->name('kelas.show');
        Route::get('/kelas/{kelas}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
        Route::put('/kelas/{kelas}', [KelasController::class, 'update'])->name('kelas.update');
        Route::delete('/kelas/{kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy');

        Route::get('/participants', ParticipantIndex::class)->name('participants.index');
        Route::get('/participants/{participant}', ShowParticipant::class)->name('participant.show');
    });

});



