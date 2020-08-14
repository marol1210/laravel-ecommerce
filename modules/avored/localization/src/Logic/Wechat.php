<?php 
namespace AvoRed\Localization\Logic;

use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use EasyWeChat\OpenPlatform\Server\Guard;
use EasyWeChat\Kernel\Messages\Text;

/**
 * 开放平台业务封装（目前只支持单一开放平台）
 * 所有方法操作的对象，都是基于已经接入了微信开放平台
 * 
 * @author mma
 */
class Wechat 
{
    protected $appid;
    
    protected $notify_appid; //发送系统通知消息的公众号
    
    /**
     * 要授权的帐号类型：
     *  1 表示商户点击链接后，手机端仅展示公众号、
     *  2 表示仅展示小程序，
     *  3 表示公众号和小程序都展示。如果为未指定，则默认小程序和公众号都展示。
     *  
     *  第三方平台开发者可以使用本字段来控制授权的帐号类型。
     * @var integer
     */
    protected $auth_type = 1;
    
    public function __construct()
    {
    }
    
    public function init($config)
    {
        if(empty($config)){
            throw new \Exception(static::class.'的初始化配置参数不能为空.');
        }
        foreach($config as $k=>$v){
            $this->$k = $v;
        }
    }
    
    public function validate()
    {
        if(empty($this->appid)){
            throw new \Exception(static::class.'的初始化配置参数 `appid` 不能为空.');
        }
    }
    
    public function __get($name)
    {
        if($name != 'appid'){
            return null;
        }
        $this->$name = app('request')->get('appid');
        return $this->name;
    }
    
    /**
     * 微信「公众号 & 开放平台」接入callback_url
     * @param Request $request
     * @param String $app_id
     * @return string|\Symfony\Component\HttpFoundation\Response
     */
    public function callback(Request $request , $appid = null)
    {
        if(!empty($appid)){
            $this->appid = $appid;
        }
        
        if ($request->isMethod('get')) {
            if (empty($this->appid) || config("wechat.{$this->appid}")) {
                return 'fail';
            }
            $config = config("wechat.{$this->appid}");
            
            $app = Factory::officialAccount($config);
            $response = $app->server->serve();
            return $response;
        }

        $official_config = app()['config']['wechat']['official_platform'];
        $wechat_official_platform = Factory::officialAccount($official_config);
        
        $openplatform_config = app()['config']['wechat']['open_platform'];
        $wechat_open_platform = Factory::openPlatform($openplatform_config);

        if (empty($this->appid)) {
            $wechat_open_platform->server->push(function ($message) use ($official_config,$wechat_open_platform) {
                $text = new Text('Welcome to XiaoMa');
                $wechat_official_platform = Factory::officialAccount(app()['config']['wechat']['wxc559720c36af59b0']);
                $openid = 'obG7qt0AyPev_7JA1_oXffGYfooc';
                $wechat_official_platform->customer_service->message($text)->to($openid)->send();
            }, Guard::EVENT_AUTHORIZED);
            
            return $wechat_open_platform->server->serve();
        } else {
            if ($this->appid == 'wxc559720c36af59b0') {
                //请求微信授权，返回按钮授权形式
                $wechat_official_platform->server->push(function($message) use($wechat_open_platform){
                    //开放平台按钮方式授权url
                    //$url = $wechat_open_platform->getMobilePreAuthorizationUrl('http://xn--xkrp7r.cn/ecstore/index.php/openAuth',['auth_type'=>1]);
                    
                    $url = 'http://xn--xkrp7r.cn/ecstore/index.php/oauth'; //如果没有配置指定公众号，默认使用平台公众号进行网页授权，并跳转授权开放平台； 目的是成功授权后，向网页授权用户发送成功消息；
                    return 'Welcome~'.PHP_EOL."<a href='{$url}'>前往授权开放平台</a>";
                });
            } else {
                $wechat_official_platform = $wechat_open_platform->officialAccount($this->appid);
                $wechat_official_platform->server->push(function ($message) {
                    switch ($message['MsgType']) {
                        case 'event':
                            return '收到事件消息';
                            break;
                        case 'text':
                                $rs = $this->autoTest($message);
                                if($rs !== false){
                                    return $rs;
                                }
                            break;
                        case 'image':
                            return '收到图片消息';
                            break;
                        case 'voice':
                            return '收到语音消息';
                            break;
                        case 'video':
                            return '收到视频消息';
                            break;
                        case 'location':
                            return '收到坐标消息';
                            break;
                        case 'link':
                            return '收到链接消息';
                            break;
                        case 'file':
                            return '收到文件消息';
                    }
                    return <<<eot
感谢您的关注~
1.<a href='http://xn--xkrp7r.cn/game-2048/'>小游戏</a>
2.<a href='http://xn--xkrp7r.cn:8080'>在线电商</a>
3.联系邮箱:
    mzh1986love@sina.com
eot;
                });
            }
            return $wechat_official_platform->server->serve();
        }
    }
    
    /**
     * 微信号(公众号、小程序)授权开放平台callback
     */
    public function authOpenPlatform()
    {
        try{
            $open_platform = Factory::openPlatform(app()['config']['wechat']['open_platform']);
            $result = $open_platform->handleAuthorize();
            Cache::set('refresh_actoken.'.$result['authorization_info']['authorizer_appid'],$result);

            /*
            $wechat_official_platform = Factory::officialAccount($this->appid);
            */
            //来自网页授权
            if(app('request')->has('code')){
                $appid = 'wxc559720c36af59b0';
                $wechat_official_platform = Factory::officialAccount(app()['config']['wechat'][$appid]);
                $wechat_user = $wechat_official_platform->oauth->user();
                $text = new Text('Welcome to XiaoMa'.PHP_EOL.'授权成功.');
                $wechat_official_platform->customer_service->message($text)->to($wechat_user->getId())->send();
            }
            //db save
            
        }catch(\Exception $ex){
            if(
                $ex instanceof \EasyWeChat\Kernel\Exceptions\InvalidArgumentException ||
                $ex instanceof \EasyWeChat\Kernel\Exceptions\InvalidConfigException ||
                $ex instanceof \EasyWeChat\Kernel\Exceptions\RuntimeException
                )
            {
                //触发联系通知机制
                throw $ex;
            }
            throw new \Exception('error::授权开放平台::'.$ex->getTraceAsString());
        }
        
        return view('localization::widget.success');
    }
    
    public function autoTest($message)
    {
        //$this->appid = "wx570bc396a51b8ff8";
        
        if($message['Content'] == 'TESTCOMPONENT_MSG_TYPE_TEXT'){
            return 'TESTCOMPONENT_MSG_TYPE_TEXT_callback';
        }
        
        if(strpos($message['Content'],'QUERY_AUTH_CODE:') !== false){
            $code = explode(':', $message['Content']);
            $open_platform = Factory::openPlatform(app()['config']['wechat']['open_platform']);
            $open_platform_auth_call_back = 'http://xn--xkrp7r.cn/ecstore/index.php/openAuth';
            $open_platform_url = $open_platform->getMobilePreAuthorizationUrl($open_platform_auth_call_back,['pre_auth_code'=>$code[1]]);
            redirect()->away($open_platform_url);
            sleep(2);
            $app = $open_platform->officialAccount('wx570bc396a51b8ff8');
            $text = "{$code[1]}_from_api";
            $app->customer_service->message($text)->to($message['FromUserName'])->send();
            return '';
        }
        
        return false;
    }
    
    /**
     * 公众号网页授权
     */
    public function redirectOAuth($appid = 'wxc559720c36af59b0')
    {
        if(!empty($appid)){
            $this->appid = $appid;
        }
        
        //网页授权后跳转地址
        if(app('request')->has('code')){
            $open_platform = Factory::openPlatform(app()['config']['wechat']['open_platform']);
            $open_platform_auth_call_back = 'http://xn--xkrp7r.cn/ecstore/index.php/openAuth?code='.app('request')->get('code');
            $open_platform_url = $open_platform->getMobilePreAuthorizationUrl($open_platform_auth_call_back,['auth_type'=>1]);
            return redirect()->away($open_platform_url);
        }
        /*
        $open_platform = Factory::openPlatform(app()['config']['wechat']['open_platform']);
        $app = $open_platform::officialAccount($appid);
        */
        $app = Factory::officialAccount(app()['config']['wechat'][$appid]);
        return $app->oauth->scopes(['snsapi_base'])->redirect(url()->current());
    }
}