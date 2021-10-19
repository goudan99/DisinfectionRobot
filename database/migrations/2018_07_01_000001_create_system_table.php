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
		
       Schema::create('configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group_label', 24)->default('')->comment('分组标签名,显示');
            $table->string('group_name', 24)->default('')->comment('分组名,计算机识别');
            $table->string('name', 24)->default('')->comment('名称');
            $table->string('key', 188)->default('')->comment('键')->unique();
            $table->longText('value')->nullable()->comment('值');
            $table->string('field_type', 24)->nullable()->default('字段类型');
            $table->integer('sort')->default(0)->comment('升序');
            $table->longText('default_value')->nullable()->default(null)->comment('默认值');
            $table->text('option_value')->nullable()->default(null)->comment('可选值');
            $table->tinyInteger('is_private')->default(0)->comment('是否私密信息');
            $table->tinyInteger('is_public')->default(0)->comment('是否公开');
            $table->string('help')->nullable()->default('')->comment('帮助信息');
            $table->timestamps();
        });
		
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
			$table->string('user_name')->nullable()->comment('所属用户,为0时可能是系统');
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
		Schema::dropIfExists('configs');
		Schema::dropIfExists('notice');
		Schema::dropIfExists('logger_api');
		Schema::dropIfExists('logger_user');
    }
}
