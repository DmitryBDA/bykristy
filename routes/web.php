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

    Route::get('/calendar/show-action-record', [CalendarController::class, 'showActionRecord'])->name('admin.calendar.action.record');

    Route::post('/calendar/create-records', [CalendarController::class, 'createRecords'])->name('admin.calendar.create.records');

    Route::post('/calendar/record-user', [CalendarController::class, 'recordUser'])->name('admin.calendar.record.user');

    Route::post('/calendar/action-record', [CalendarController::class, 'actionRecord'])->name('admin.calendar.action.record');

    Route::post('/calendar/update-date-record', [CalendarController::class, 'updateDateRecord'])->name('admin.calendar.update.date.record');

    Route::get('/calendar/autocomplete',[CalendarController::class, 'autocompletionInput'])->name('admin.calendar.autocompletionInput');

    Route::post('/calendar/search-phone',[CalendarController::class, 'searchPhone'])->name('admin.calendar.search.phone');
});
