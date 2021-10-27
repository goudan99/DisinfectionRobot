<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditRobot2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::table('machines', function (Blueprint $table) {
			$table->integer('move_speed')->nullable();
			$table->integer('power_setting')->nullable();
		});
		
		Schema::create('users', function (Blueprint $table) {
			$table->tinyInteger('is_first')->default(0)->comment('是否第一次登录为1,默认为0');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
