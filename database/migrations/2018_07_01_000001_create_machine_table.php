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
		
       Schema::create('machines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sn', 255)->default('')->comment('分组名,计算机识别');
			$table->integer('status')->nullable()->comment('当前状态');
            $table->timestamps();
        });
		
		//站内通知(暂定)
        Schema::create('job', function (Blueprint $table) {
			$table->increments('id')->comment('通知id');
			$table->integer('user_id')->nullable()->comment('所属用户');
			$table->string('title',100)->nullable()->comment('通知标题');
			$table->text('content')->nullable()->comment('通知内容');
			$table->tinyInteger('is_read')->default(0)->nullable()->comment('是否已读');
			$table->tinyInteger('type')->default(1)->nullable()->comment('通知类型');
			$table->softDeletes();
			$table->timestamps();
        });
		
		
		//任务日志
        Schema::create('logger_job', function (Blueprint $table) {
			$table->increments('id')->comment('通知id');
			$table->integer('job_id')->nullable()->comment('执行机器id');
			$table->integer('job_name')->nullable()->comment('任务名');
			$table->integer('machine_id')->nullable()->comment('设备id');
			$table->integer('machine_name')->nullable()->comment('设备名');
			$table->string('action',255)->nullable()->comment('执行动作');
			$table->integer('status')->nullable()->comment('当前状态');
			$table->timestamps();
        });
		
		//任务日志
        Schema::create('logger_user', function (Blueprint $table) {
			$table->increments('id')->comment('通知id');
			$table->integer('user_id')->nullable()->comment('操作用户');
			$table->string('user_name')->nullable()->comment('用户名');
			$table->text('content')->nullable()->comment('操作名');
			$table->text('data')->nullable()->comment('操作数据');
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
		Schema::dropIfExists('machine');
		Schema::dropIfExists('job');
		Schema::dropIfExists('logger_job');
    }
}
