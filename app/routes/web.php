<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\InvitationController;
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

Route::get('/', [DisplayController::class, 'index'])->name('home');
Route::get('/home', [DisplayController::class, 'homeindex']);
Route::get('/graph/{year}/{month}', [DisplayController::class, 'graph'])->name('graph');
Route::get('/create_goal',  [RegistrationController::class, 'createGoalForm'])->name('create.goal');
Route::post('/create_goal',  [RegistrationController::class, 'createGoal']);
Route::get('/edit_goal/{id}',  [RegistrationController::class, 'editGoalForm'])->name('edit.goal');
Route::post('/edit_goal/{id}',  [RegistrationController::class, 'editGoal']);
Route::delete('/delete_goal/{id}',  [RegistrationController::class, 'deleteGoal'])->name('delete.goal');
Route::get('/create_spend',  [RegistrationController::class, 'createSpendForm'])->name('create.spend');
Route::post('/create_spend',  [RegistrationController::class, 'createSpend']);
Route::get('/create_income',  [RegistrationController::class, 'createIncomeForm'])->name('create.income');
Route::post('/create_income',  [RegistrationController::class, 'createIncome']);
Route::delete('/delete_spend/{id}',  [RegistrationController::class, 'deleteSpend'])->name('delete.spend');
Route::delete('/delete_income/{id}',  [RegistrationController::class, 'deleteIncome'])->name('delete.income');
Route::get('/edit_income/{id}',  [RegistrationController::class, 'editIncomeForm'])->name('edit.income');
Route::post('/edit_income/{id}',  [RegistrationController::class, 'editIncome']);
Route::get('/edit_spend/{id}',  [RegistrationController::class, 'editSpendForm'])->name('edit.spend');
Route::post('/edit_spend/{id}',  [RegistrationController::class, 'editSpend']);
Route::get('/invitation',  [InvitationController::class, 'invitationForm'])->name('invitation');
Route::post('/invitation',  [InvitationController::class, 'invitation']);
Route::get('/create_invitation',  [InvitationController::class, 'createInvitation'])->name('create.invitation');
Route::get('/calendar', [DisplayController::class, 'calendarIndex'])->name('calendar.index');
Route::get('/detail_calendar/{date}', [DisplayController::class, 'detailCalendar'])->name('detail.calendar');

Route::get('/child_mypage', function () {
    return view('child_mypage');
})->name('child.mypage');

Route::get('/parent_mypage', function () {
    return view('parent_mypage');
})->name('parent.mypage');
