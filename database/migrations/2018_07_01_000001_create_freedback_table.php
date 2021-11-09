<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		
       Schema::create('freedbacks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->string('user_name', 255)->nullable()->default('')->comment('用户名');
			$table->string('phone', 255)->nullable()->default('')->comment('手机号码');
			$table->text('desc')->nullable()->comment('问题描述');
			$table->text('pics')->nullable()->comment('问题描述');
			$table->integer('status')->nullable()->comment('处理状态');
            $table->timestamps();
        });
		
		/*上传管理*/
       Schema::create('uploads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->string('user_name', 255)->nullable()->default('')->comment('用户名');
			$table->string('url', 255)->nullable()->default('')->comment('文件url');
			$table->integer('from_type')->nullable()->default(0)->comment('文件来源,0为系统产生，即机器扫描出来，1为用户上传,');
			$table->integer('from_id')->nullable()->default(0)->comment('文件来源者,type0时此值是机器id,当1时此值是分享者的id或上传者id');
			$table->text('remark')->nullable()->comment('说明');
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
		Schema::dropIfExists('freedback');
		Schema::dropIfExists('uploads');
    }
}
