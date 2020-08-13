<?php
Route::prefix('cn')->namespace('\AvoRed\Localization\Http\Controllers')->group(function () {
    Route::get('/register', 'RegisterController@showRegistrationForm')->name('cn.register');
    Route::view('/login', 'localization::auth.login');
});


Route::namespace('\AvoRed\Localization\Http\Controllers')->group(function () {
    Route::get('/wechat_callback/{app_id?}', 'WechatController@callback');
    Route::post('/wechat_callback/{app_id?}', 'WechatController@callback');
    Route::get('/cache/{appid?}', function ($appid) {
        dump(Cache::get("refresh_actoken.{$appid}"));
    });
    Route::get('/openAuth', 'WechatController@authOpenPlatform');
});