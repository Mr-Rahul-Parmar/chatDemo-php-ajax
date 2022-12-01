<?php

use App\Http\Controllers\Admin\chatBuddyController;
use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\SocialLoginController;
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
    return view('admin.auth.login');
});

Route::namespace('auth')->group(function (){
    Route::get('login',[LoginController::class,'login'])->name('login');
    Route::post('login-process',[LoginController::class,'loginProcess']);
    Route::get('register',[LoginController::class,'register']);
    Route::post('register-process',[LoginController::class,'registerProcess']);
    Route::get('logout',[LoginController::class,'logout']);

    Route::get('chat-buddy',[chatBuddyController::class,'chatBuddy'])->name('chatBuddy');
    Route::get('user-list',[chatBuddyController::class,'chatUserList'])->name('userList');
    Route::get('/chat-buddy/user/{id}',[chatBuddyController::class,'chatBuddyUserChat'])->name('chat.user');
//    Route::post('chat-buddy-message',[chatBuddyController::class,'chatBuddyMessage']);
    Route::post('/chat-buddy/send',[chatBuddyController::class,'sendMessage'])->name('admin.chat.sendMessage');
    Route::post('/chat-buddy/get',[chatBuddyController::class,'getMessage']);
    Route::post('/chat-buddy/get/online-status',[chatBuddyController::class,'getOnlineStatus']);

    Route::post('/chat-buddy/get/fetch_user_chat_history',[chatBuddyController::class,'fetchMsgHistory']);

    Route::post('/chat-buddy/get/unread-msg',[chatBuddyController::class,'getUnseenMessage']);

    //Facebook - Social Login Controller
    Route::get('auth/facebook', [SocialLoginController::class, 'redirectToFB']);
    Route::get('callback/facebook', [SocialLoginController::class, 'handleCallbackFB']);

    //Google - Social Login Controller
    Route::get('auth/google', [SocialLoginController::class, 'redirectToGoogle']);
    Route::get('callback/google', [SocialLoginController::class, 'handleCallbackGoogle']);

    //Twitter - Social Login Controller
    Route::get('auth/twitter', [SocialLoginController::class, 'redirectToTwitter']);
    Route::get('callback/twitter', [SocialLoginController::class, 'handleCallbackTwitter']);

    Route::post('update_is_type_status', [chatBuddyController::class, 'chatStatus']);
    Route::post('typing-status',[chatBuddyController::class,'fetch_is_type_status']);

    Route::get('auth/otp',[LoginController::class,'otpLogin']);
    Route::get('verification',[LoginController::class,'verifyOtp']);

});

Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::get('email-verification',[LoginController::class,'emailVerify']);
Route::post('request_otp',[LoginController::class,'requestOtp']);
Route::post('verify-email-otp',[LoginController::class,'verifyEmailOtp']);

Route::get('test-ajax', function () {
    $connect = new PDO("mysql:host=localhost;dbname=ChatBuddy", "root", "3rd@123");
    $user_id = \Illuminate\Support\Facades\Auth::id();
    $a = fetch_is_type_status($user_id,$connect);
    dd($a);
});
