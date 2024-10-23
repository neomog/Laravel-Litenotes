<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrashedController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect('/notes');
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/notes', NoteController::class)->middleware(['auth']);

Route::prefix('/trashed')->name('trashed.')->middleware('auth')->group(function()
{
    Route::get('/', [TrashedController::class, 'index'])->name('index');
    Route::get('/{note}', [TrashedController::class, 'show'])->name('show')->withTrashed();
    Route::put('/{note}', [TrashedController::class, 'update'])->name('update')->withTrashed();
    Route::delete('/{note}', [TrashedController::class, 'destroy'])->name('destroy')->withTrashed();
});

require __DIR__.'/auth.php';
