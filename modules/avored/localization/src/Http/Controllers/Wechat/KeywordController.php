<?php
namespace AvoRed\Localization\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rs = \AvoRed\Localization\Models\WechatKeyword::where('status','enable')->get();
        $list = [];
        foreach($rs as $r){
            if(!isset($list[$r['uuid']])){
                $list[$r['uuid']] = [];
            }
            array_push($list[$r['uuid']] , $r);
        }
        return view("localization::wechat.keyword",['list'=>$list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(['keywords'=>['required'],'message'=>['required'],'type'=>['required']], $request->post());
        $keyword = new \AvoRed\Localization\Logic\Keyword();
        return ($rs = $keyword->createDb($validatedData))=== true ? ['errcode'=>0 , 'errmsg'=>'ok'] : ['errcode'=>-1 , 'errmsg'=>$rs->getMessage()];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(empty($id)){
            
        }else{
            
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
