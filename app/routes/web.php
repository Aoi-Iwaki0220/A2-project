<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Admin\AdminController;
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

Auth::routes();
Route::get('/password/reset/form', function() {
    $token = 'sample-token';  
    return view('password_reset', compact('token'));
});
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['parentOrChild']], function () {  //保護者とこども共通
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/home', [DisplayController::class, 'index'])->name('home');
    Route::get('/detail_calendar/{date}', [DisplayController::class, 'detailCalendar'])->name('detail.calendar');
    Route::get('/calendar', [DisplayController::class, 'calendarIndex'])->name('calendar.index');
    Route::get('/graph/{year}/{month}', [DisplayController::class, 'graph'])->name('graph');
    Route::get('/preview_graph/{year}/{month}', [DisplayController::class, 'previewGraph'])->name('preview.graph');
    Route::post('/message_read/{id}',  [MessageController::class, 'messageRead'])->name('message.read');
    
});    

Route::group(['middleware' => ['auth:child', 'child']], function () {    //こどものみ 
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
    Route::get('/create_invitation',  [InvitationController::class, 'createInvitation'])->name('create.invitation');
    Route::get('/child_mypage', [DisplayController::class, 'childMypage'])->name('child.mypage');
    Route::get('/edit_child',  [RegistrationController::class, 'editChildForm'])->name('edit.child');
    Route::post('/edit_child',  [RegistrationController::class, 'editChild']);
    Route::get('/message_list',  [MessageController::class, 'messageListForm'])->name('message.list');
    Route::post('/message_list',  [MessageController::class, 'messagelist']);
});

Route::group(['middleware' => ['auth:parent', 'parent']], function () {
    Route::get('/invitation',  [InvitationController::class, 'invitationForm'])->name('invitation');
    Route::post('/invitation',  [InvitationController::class, 'invitationCode']);
    Route::get('/parent_mypage', [DisplayController::class, 'parentMypage'])->name('parent.mypage');
    Route::get('/edit_parent',  [RegistrationController::class, 'editParentForm'])->name('edit.parent');
    Route::post('/edit_parent',  [RegistrationController::class, 'editParent']);
    Route::post('/unlink_child', [DisplayController::class, 'unlinkChild'])->name('unlink.child');
    Route::get('send_message', [MessageController::class, 'sendMessageForm'])->name('send.message');
    Route::post('send_message', [MessageController::class, 'sendMessage']);
});

Route::group(['middleware' => ['auth:admin', 'admin']], function () {
    Route::get('/management', [AdminController::class, 'index'])->name('management');
    Route::get('/search_user', [AdminController::class, 'searchUser'])->name('search.user');
     Route::get('/search_userhistory', [AdminController::class, 'searchUserHistory'])->name('search.userhistory');
});