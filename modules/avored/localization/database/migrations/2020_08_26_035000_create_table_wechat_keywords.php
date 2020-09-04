<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWechatKeywords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_keywords', function (Blueprint $table) {
            $table->uuid('uuid')->comment('批次号');
            $table->unsignedSmallInteger('id')->comment('批次内的关键字号');
            $table->integer('create_user_id')->commit('创建者');
            $table->string('name',30)->comment('关键字名');
            $table->string('status')->default('enable')->comment('状态');
            $table->timestamps();
            $table->engine = 'MyISAM';
            $table->primary(['uuid', 'id']);
            $table->charset = 'utf8mb4';
        });
        
        DB::statement('alter table wechat_keywords modify id tinyint unsigned auto_increment');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keywords');
    }
}
