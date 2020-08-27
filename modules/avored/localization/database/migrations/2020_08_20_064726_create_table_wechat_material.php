<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWechatMaterial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',100)->comment('标题');
            $table->string('type',15)->comment('素材类型: text , news等； 和微信保持一直');
            $table->json('content')->comment('某序列化的素材类型');
            $table->integer('create_user_id')->comment('创建者');
            $table->integer('material_able_id')->comment('素材多态； 素材可属于用户，也可属于角色；');
            $table->string('material_able_type',255)->comment('所属多态类');
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
        Schema::dropIfExists('materials');
    }
}
