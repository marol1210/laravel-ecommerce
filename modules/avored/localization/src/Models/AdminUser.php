<?php
namespace AvoRed\Localization\Models;

use AvoRed\Framework\Database\Models\AdminUser as Model;

class AdminUser extends Model
{
    protected $fillable = ['authorizer_appid','authorizer_access_token','authorizer_refresh_token','func_info','openid'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    //protected $guarded = [];
    
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'func_info' => '{}',
    ];
    
    public function wechats()
    {
        return $this->belongsToMany('AvoRed\Localization\Models\WechatAccount','admin_users_wehcat_accounts', 'sys_user_id','openid','id','openid');
    }
}