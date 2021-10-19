<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::table('notice', function (Blueprint $table) {
			$table->string('form_id')->nullable();
			$table->string('is_top')->nullable();
		});
		
		Schema::table('machines', function (Blueprint $table) {
			$table->string('macid')->nullable();
		});
		
		Schema::table('jobs', function (Blueprint $table) {
			$table->integer('status')->nullable();
			$table->integer('type_id')->nullable();
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
