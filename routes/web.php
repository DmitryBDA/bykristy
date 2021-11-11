<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\CalendarController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('admin.index');

    Route::get('/calendar', [CalendarController::class, 'index'])->name('admin.calendar.index');

    Route::get('/calendar/records', [CalendarController::class, 'records'])->name('admin.calendar.records');
});
