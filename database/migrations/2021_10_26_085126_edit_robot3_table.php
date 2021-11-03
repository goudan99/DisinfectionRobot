<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditRobot3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('roles', function (Blueprint $table) {
			$table->integer('level')->default(0)->comment('角色特级,数字大的可以看到数字小的角色数据');
		});
		
		Schema::create('machine_user', function (Blueprint $table) {
			$table->integer('user_id')->comment('用户id');
			$table->integer('machine_id')->comment('设备id');
			$table->string('machine_name',100)->unique()->comment('设备名称');
			$table->primary(['machine_id', 'user_id']);
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
