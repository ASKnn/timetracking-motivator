<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnUsersController;
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

Route::get('dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('add-redmine-user', function () {
    return view('adding_redmine_user');
})->middleware(['auth'])->name('add-redmine-user');

Route::post("adding_new_redmine_user", [OwnUsersController::class, 'addOwnUser'])
    ->middleware(['auth'])->name('add_new_redmine_user');

Route::get('get-all-users', [OwnUsersController::class, 'getAllUsers'])
    ->middleware(['auth'])->name('showAllUsers');
Route::get('get-all-time-entries', [OwnUsersController::class, 'getAllTimeEntries'])
    ->middleware(['auth'])->name('get-all-time-entries');



require __DIR__.'/auth.php';
