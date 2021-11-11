<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		
		Schema::table('users', function (Blueprint $table) {
			$table->integer('company_id')->default(0)->comment('所属企业');
		});
		Schema::table('roles', function (Blueprint $table) {
			$table->integer('company_id')->default(0)->comment('所属企业');
		});
		Schema::table('accesses', function (Blueprint $table) {
			$table->integer('company_id')->default(0)->comment('所属企业');
		});
		Schema::table('freedbacks', function (Blueprint $table) {
			$table->integer('company_id')->default(0)->comment('所属企业');
		});
		Schema::table('invites', function (Blueprint $table) {
			$table->integer('company_id')->default(0)->comment('所属企业');
		});
		Schema::table('menus', function (Blueprint $table) {
			$table->integer('company_id')->default(0)->comment('所属企业');
		});
		Schema::table('uploads', function (Blueprint $table) {
			$table->integer('company_id')->default(0)->comment('所属企业');
		});
		Schema::table('notice', function (Blueprint $table) {
			$table->integer('company_id')->default(0)->comment('所属企业');
		});
		Schema::table('machines', function (Blueprint $table) {
			$table->integer('company_id')->default(0)->comment('所属企业');
		});
		Schema::table('maps', function (Blueprint $table) {
			$table->integer('company_id')->default(0)->comment('所属企业');
		});
		
		Schema::table('jobs', function (Blueprint $table) {
			$table->integer('company_id')->default(0)->comment('所属企业');
		});
		
    }
}
