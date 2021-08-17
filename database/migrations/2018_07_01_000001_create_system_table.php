<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		
		//站内通知(暂定)
        Schema::create('notice', function (Blueprint $table) {
			$table->increments('id')->comment('通知id');
			$table->integer('user_id')->nullable()->comment('所属用户');
			$table->string('title',100)->nullable()->comment('通知标题');
			$table->text('content')->nullable()->comment('通知内容');
			$table->tinyInteger('is_read')->default(0)->nullable()->comment('是否已读');
			$table->tinyInteger('type')->default(1)->nullable()->comment('通知类型');
			$table->softDeletes();
			$table->timestamps();
        });
		
		//前端日志
        Schema::create('logger_api', function (Blueprint $table) {
			$table->increments('id')->comment('id');
			$table->string('code')->nullable()->comment('编码');
			$table->text('msg')->nullable()->comment('返回内容');
			$table->string('url')->default(0)->nullable()->comment('地址');
			$table->string('type')->default(1)->nullable()->comment('类型');
			$table->timestamps();
        });
		
		//用户操作日志
        Schema::create('logger_user', function (Blueprint $table) {
			$table->increments('id')->comment('通知id');
			$table->integer('user_id')->nullable()->comment('所属用户,为0时可能是系统');
			$table->string('name',100)->nullable()->comment('操作对象');
			$table->string('content',100)->nullable()->comment('操作详情');
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
		Schema::dropIfExists('notice');
		Schema::dropIfExists('logger_api');
		Schema::dropIfExists('logger_user');
    }
}
