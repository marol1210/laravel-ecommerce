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
        return view("localization::wechat.keyword");
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
        $key_name = $validatedData['type'].'.'.auth()->id();
        
        $cache_data = collect([]);
        $history = cache($key_name);
        if(!empty($history)){
            /*
            $keywords = $validatedData['keywords'];
            $history->filter(function ($value, $key) use($keywords) {
                foreach($keywords as $kw){
                    //存在重复
                    if(in_array($kw,$value)){
                        return false;
                    }
                }
            });
            */
            $cache_data = $history->concat([$validatedData]);
        }else{
            $cache_data = collect([$validatedData]);
        }
        cache([$key_name=>$cache_data]);
        return '';
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
        //
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
