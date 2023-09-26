<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('events', [EventController::class, 'index'])->name("event")->middleware('auth');
Route::post('events', [EventController::class, 'store'])->name("event.store")->middleware('auth');

Route::get('events/show/{event}', [EventController::class, 'show'])->name("event.show")->middleware('auth');
Route::get('events/edit/{event}', [EventController::class, 'edit'])->name("event.edit")->middleware('auth');
Route::get('events/create', [EventController::class, 'create'])->name("event.create")->middleware('auth');
Route::patch('events/update/{event}', [EventController::class, 'update'])->name("event.update")->middleware('auth');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';