<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditRobotTable extends Migration
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
			$table->integer('job_status')->nullable();
			$table->integer('job_progress')->nullable();
			$table->integer('power_num')->nullable();
			$table->integer('machine_area')->nullable();
			$table->integer('work_area')->nullable();
			$table->integer('work_time')->nullable();
			$table->integer('work_num')->nullable();
			$table->integer('cpu_tempe')->nullable();
			$table->integer('cpu_usage')->nullable();
			$table->integer('hdd_usage')->nullable();
			$table->string('wifi_name')->nullable();
			$table->string('wifi_stronge')->nullable();
			$table->string('wifi_type')->nullable();
			$table->string('wifi_ip')->nullable();
			$table->string('wifi_macid')->nullable();
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
