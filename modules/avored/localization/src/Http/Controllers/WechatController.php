<?php
namespace AvoRed\Localization\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WechatController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }
    /**
     * 微信「公众号 & 开放平台」接入callback_url
     * @param Request $request
     * @param String $app_id
     * @return string|\Symfony\Component\HttpFoundation\Response
     */
    public function callback(Request $request, $appid = null)
    {
        return app('wechat')->callback($request,$appid);
    }
    
    /**
     * 微信号(公众号、小程序)授权开放平台
     */
    public function authOpenPlatform()
    {
        return app('wechat')->authOpenPlatform();
    }
}