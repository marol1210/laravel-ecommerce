<?php

use Illuminate\Support\Facades\Auth;

Route::get('/register-cn',[\AvoRed\Localization\Http\Controllers\RegisterController::class,'showRegistrationForm'])->name('marol.register.cn');


Route::get('/abc',function(){
    return (new \Illuminate\Auth\Notifications\VerifyEmail())->toMail(Auth::user());
});