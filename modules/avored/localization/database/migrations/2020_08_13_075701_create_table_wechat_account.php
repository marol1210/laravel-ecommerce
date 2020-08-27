<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

class CreateTableWechatAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('authorizer_appid',45)->comment('授权方 appid');
            $table->string('authorizer_access_token',255)->comment('接口调用令牌（在授权的公众号/小程序具备 API 权限时，才有此返回值）');
            $table->string('authorizer_refresh_token',45)->comment('刷新令牌（在授权的公众号具备API权限时，才有此返回值），刷新令牌主要用于第三方平台获取和刷新已授权用户的 authorizer_access_token。一旦丢失，只能让用户重新授权，才能再次拿到新的刷新令牌。用户重新授权后，之前的刷新令牌会失效');
            $table->json('func_info');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechat_account');
    }
}
