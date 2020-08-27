<?php 
namespace AvoRed\Localization\Logic;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


/**
 * 开放平台业务封装（目前只支持单一开放平台）
 * 所有方法操作的对象，都是基于已经接入了微信开放平台
 * 
 * @author mma
 */
class Keyword 
{
    /**
     * 创建关键字 - cache存放
     * @param array $validatedData  [key=>value,...]
     */
    public function createCache($validatedData){
        $current_user_id = auth()->id();
        $key_name = $validatedData['type'].'.'.$current_user_id;
        $cache_data = collect([]);
        $history = cache($key_name);
        if(!empty($history)){
            $cache_data = $history->concat([$validatedData]);
        }else{
            $cache_data = collect([$validatedData]);
        }
        return cache([$key_name=>$cache_data]);
    }
    
    /**
     * 创建关键字 - DB存放
     * @param array $validatedData  [key=>value,...]
     */
    public function createDb($validatedData){
        $current_user_id = auth()->id();
        $current_user_id = 1;
        $uuid = Str::uuid();
        $current_date = date('Y-m-d H:i:s');
        
        try {
            DB::beginTransaction();
            foreach($validatedData['keywords'] as $kw){
                \AvoRed\Localization\Models\WechatKeyword::insert(['uuid'=>$uuid , 'create_user_id'=>$current_user_id , 'name'=>$kw , 'created_at'=> $current_date ]);
            }
            \AvoRed\Localization\Models\WechatKeywordContent::insert(['create_user_id'=>$current_user_id, 'content'=>$validatedData['message'],'keyword_id'=>$uuid , 'created_at'=> $current_date]);
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return $e;
        }
        return true;
    }
}