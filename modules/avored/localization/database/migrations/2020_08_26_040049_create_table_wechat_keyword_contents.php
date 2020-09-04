<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWechatKeywordContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_keyword_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('keyword_id')->commit('关键字uuid');
            $table->integer('create_user_id')->commit('创建者');
            $table->text('content')->commit('内容');
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
        Schema::dropIfExists('keyword_contents');
    }
}
