<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
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
            
            $table->string('title',200)->comment('标题');
            $table->string('status',15)->default('enable')->comment('状态');
            $table->string('type',15)->comment('素材类型: text , news等； 和微信保持一直');
            $table->json('content')->comment('素材内容');
            $table->integer('create_user_id')->comment('创建者');
            
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
        Schema::dropIfExists('wechat_materials');
    }
}
