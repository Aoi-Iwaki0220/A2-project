<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\RegistrationController;
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

//Route::get('/', function () {
//    return view('welcome');
//});

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [DisplayController::class, 'index']);
Route::get('/create_goal',  [RegistrationController::class, 'createGoalForm'])->name('create.goal');
Route::post('/create_goal',  [RegistrationController::class, 'createGoal']);
Route::get('/edit_goal/{id}',  [RegistrationController::class, 'editGoalForm'])->name('edit.goal');
Route::post('/edit_goal/{id}',  [RegistrationController::class, 'editGoal']);

