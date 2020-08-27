<?php
namespace AvoRed\Localization\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 微信素材资源
 * @author mma
 *
 */
class WechatMaterial extends Model
{
    protected $table="wechat_materials";
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
