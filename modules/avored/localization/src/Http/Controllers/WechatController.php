<?php
namespace AvoRed\Localization\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * 已接入开放平台列表
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $user = Auth::guard('admin')->user();
        $wechat = $user->wechats;
        return view('avored::system.wechat.index',compact('wechat'));
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