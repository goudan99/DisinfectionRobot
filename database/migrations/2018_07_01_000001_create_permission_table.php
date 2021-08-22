<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		//用户
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id',100)->comment('用户id唯一值');
            $table->string('name',100)->unique()->comment('登录帐号');
			$table->string('password')->comment('密码凭证：站内的保存密码、站外的不保存或保存token）');
			$table->string('nickname')->default('')->nullable()->comment('昵称帐号');
			$table->string('phone')->default('')->nullable()->comment('用户手机');
			$table->string('email')->default('')->nullable()->comment('用户邮箱');
			$table->string('role_id')->default('')->nullable()->comment('角色id');
			$table->string('role_name')->default('')->nullable()->comment('角色名');
			$table->string('avatar')->default('')->nullable()->comment('用户头像');	
			$table->timestamp('last_at')->nullable()->comment('上次登录时间');
			$table->string('last_ip')->default('')->nullable()->comment('上次登录ip');
			$table->integer('login_times')->nullable()->default(0)->comment('登录次数');
			$table->tinyInteger('passed')->nullable()->default(1)->comment('帐号状态,0不可用，1已启用');
			$table->tinyInteger('is_system')->default(0)->comment('系统角色为1,默认为0');
            $table->string('desc')->nullable()->default('')->comment('用户描述');
            $table->timestamps();
        });		
		
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id',100)->comment('id值');
            $table->string('name',100)->unique()->comment('角色名称');
			$table->string('desc')->default('')->nullable()->comment('角色描述');
			$table->tinyInteger('status')->nullable()->default(1)->comment('状态:0-无效 1-有效');
			$table->tinyInteger('is_system')->default(0)->comment('保留数据0-否 1-是 不允许删除');
            $table->timestamps();			
        });
		
		//菜单
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id')->comment('id值');
            $table->integer('parent_id')->comment('上级id');	
			$table->string('name',100)->comment('菜单名称');
            $table->string('desc',100)->nullable()->comment('');
            $table->string('prefix')->nullable()->comment('路径前缀');
			$table->string('path')->nullable()->comment('菜单路径');
			$table->string('icon')->nullable()->comment('菜单图标');
			$table->string('target')->comment('打开方式:_self窗口内,_blank新窗口');
			$table->integer('order')->default(1)->nullable()->comment('优先级 越小越靠前');
			$table->tinyInteger('status')->default(1)->nullable()->comment('状态:0-无效 1-有效');
			$table->tinyInteger('is_system')->default(0)->nullable()->comment('是否为系统内置');
            $table->timestamps();			
        });
		
		//权限
        Schema::create('accesses', function (Blueprint $table) {
            $table->increments('id')->comment('id值');
            $table->integer('parent_id')->comment('上级id');	
			$table->string('name',100)->nullable()->comment('权限名称');
            $table->string('code',100)->nullable()->comment('权限标识');
			$table->string('path')->nullable()->comment('权限对应操作路径');
			$table->string('method')->nullable()->comment('路径处理方法');
            $table->string('desc',100)->nullable()->comment('权限描述');
            $table->timestamps();			
        });
		
		/*角色权限*/
        Schema::create('access_role', function (Blueprint $table) {
			$table->integer('role_id')->comment('角色id');
			$table->integer('access_id')->comment('权限id');
			$table->primary(['role_id', 'access_id']);			
        });
		
		//菜单权限
        Schema::create('access_menu', function (Blueprint $table) {
			$table->integer('menu_id')->comment('菜单id');
			$table->integer('access_id')->comment('权限id');
			$table->primary(['menu_id', 'access_id']);	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('accounts');
        Schema::dropIfExists('users');		
		Schema::dropIfExists('roles');
		Schema::dropIfExists('menus');
		Schema::dropIfExists('accesses');
		Schema::dropIfExists('access_role');	
		Schema::dropIfExists('access_menu');		
    }
}
