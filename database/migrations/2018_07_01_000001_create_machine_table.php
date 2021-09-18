<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMachineTable extends Migration
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
            $table->string('name', 255)->default('')->comment('机器名');
            $table->string('sn', 255)->default('')->comment('机器序列号');
			$table->integer('status')->nullable()->comment('当前状态');
            $table->timestamps();
        });
		
		//任务
        Schema::create('jobs', function (Blueprint $table) {
			$table->increments('id')->comment('通知id');
			$table->string('name',100)->nullable()->comment('通知标题');
			$table->integer('user_id')->nullable()->comment('创建用户名id');
			$table->string('user_name')->nullable()->comment('创建用户名');
			$table->integer('machine_id')->nullable()->comment('机器id');
			$table->string('machine_name')->nullable()->comment('机器名');
			$table->integer('map_id')->nullable()->comment('地图id');
			$table->string('map_name')->nullable()->comment('地图名');
			$table->text('map_area')->nullable()->comment('区域');
			$table->integer('rate_type')->nullable()->comment('执行频率');
			$table->text('work')->nullable()->comment('是否扫地');
			$table->text('is_clean')->nullable()->default(0)->comment('是否扫地');
			$table->text('is_test')->nullable()->default(0)->comment('是否巡检');
			$table->timestamp('start_at')->nullable()->comment('是否巡检');
			$table->timestamp('end_at')->nullable()->comment('是否巡检');
			$table->softDeletes();
			$table->timestamps();
        });
		
		//地图信息
        Schema::create('maps', function (Blueprint $table) {
			$table->increments('id')->comment('通知id');
			$table->string('name')->nullable()->comment('地图名');
			$table->text('area')->nullable()->comment('区域');
			$table->string('image')->nullable()->comment('地图图片');
			$table->integer('user_id')->nullable()->comment('创建者');
			$table->string('user_name')->nullable()->comment('创建者姓名');
			$table->integer('machine_id')->nullable()->comment('设备id');
			$table->string('machine_name')->nullable()->comment('设备名');
			$table->string('image_size',255)->nullable()->comment('图片大小');
			$table->string('file_size',255)->nullable()->comment('图片大小');
			$table->integer('status')->nullable()->default(0)->comment('状态,0待生成图，1可用，2待创建区域，3待完成');
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
		Schema::dropIfExists('machines');
		Schema::dropIfExists('jobs');
		Schema::dropIfExists('maps');
    }
}
