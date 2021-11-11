<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInviteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		
       Schema::create('invites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('comp_id')->default(0)->comment('企业id');
            $table->string('code', 255)->nullable()->default('')->comment('邀请码');
			$table->integer('user_id')->default(0)->comment('绑定用户的id');
			$table->integer('status')->nullable()->comment('处理状态');
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
		Schema::dropIfExists('invites');
    }
}
