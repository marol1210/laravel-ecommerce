<?php
Route::prefix('cn')->namespace('\AvoRed\Localization\Http\Controllers')->group(function () {
    Route::get('/register', 'RegisterController@showRegistrationForm')->name('cn.register');
    Route::view('/login', 'localization::auth.login');
});


Route::namespace('\AvoRed\Localization\Http\Controllers')->group(function () {
    //微信开放平台授权 & 回调
    Route::get('/wechat_callback/{appid?}', 'WechatController@callback');
    Route::post('/wechat_callback/{appid?}', 'WechatController@callback');
    Route::get('/openAuth', 'WechatController@authOpenPlatform');
    Route::get('/oauth',function(){
        $wechat = app('wechat');
        return $wechat->redirectOAuth();
    });
});


Route::prefix('admin')->namespace('\AvoRed\Localization\Http\Controllers')->group(function () {
    //微信关键字
    Route::resource('keyword', 'Wechat\KeywordController');
    //微信素材
    Route::resource('material','Wechat\MaterialController');
    //微信用户管理
    Route::resource('wuser','Wechat\UserController');
});

