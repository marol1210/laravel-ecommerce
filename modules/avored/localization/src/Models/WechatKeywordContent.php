<?php

namespace AvoRed\Localization\Models;

use Illuminate\Database\Eloquent\Model;

class WechatKeywordContent extends Model
{
    protected $table="wechat_keyword_contents";
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    
    //
    public function keywords()
    {
        return $this->hasMany(\AvoRed\Localization\Models\WechatKeyword::class,'uuid','keyword_id');
    }
}
