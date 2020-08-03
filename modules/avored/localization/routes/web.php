<?php
Route::prefix('cn')
->namespace('\AvoRed\Localization\Http\Controllers')
->group(function () {
    Route::get('/register','RegisterController@showRegistrationForm')->name('cn.register');
    Route::view('/login','localization::auth.login');
});

