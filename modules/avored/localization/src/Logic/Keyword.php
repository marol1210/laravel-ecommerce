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
    
    public function deleteCache($id)
    {
        
    }
    
    /**
     * 删除关键字
     * @param integer $id 关键字ID
     * @return \Exception|boolean
     */
    public function deleteDb($id)
    {
        try {
            DB::beginTransaction();
            \AvoRed\Localization\Models\WechatKeyword::where('uuid', $id)->delete();
            \AvoRed\Localization\Models\WechatKeywordContent::where('keyword_id', $id)->delete();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return $e;
        }
        return true;
    }
    
    public function update($validatedData)
    {
        try {
            $current_user_id = auth()->id();
            $current_user_id = 1;
            DB::beginTransaction();
            $keyword = \AvoRed\Localization\Models\WechatKeyword::where('uuid', $validatedData['id']);
            $created_at = $keyword->first()->created_at;
            \AvoRed\Localization\Models\WechatKeyword::where('uuid', $validatedData['id'])->delete();
            
            foreach($validatedData['keywords'] as $kw){
                $ar = new \AvoRed\Localization\Models\WechatKeyword;
                $ar->uuid = $validatedData['id'];
                $ar->created_at = $created_at;
                $ar->create_user_id = $current_user_id;
                $ar->name = $kw;
                $ar->save();
            }
            
            \AvoRed\Localization\Models\WechatKeywordContent::where('keyword_id', $validatedData['id'])->update(['content'=>$validatedData['message']]);
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return $e;
        }
        return true;
    }
}