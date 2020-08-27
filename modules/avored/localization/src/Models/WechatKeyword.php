<?php
namespace AvoRed\Localization\Models;

use Illuminate\Database\Eloquent\Model;

class WechatKeyword extends Model
{

    protected $table="wechat_keywords";
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    //
    public function contents()
    {
        return $this->hasOne(\AvoRed\Localization\Models\WechatKeywordContent::class,'keyword_id','uuid');
    }
}
