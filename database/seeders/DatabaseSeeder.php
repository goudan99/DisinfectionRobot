<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([[		
            'nickname' => '管理员',     			
            'phone' => '15113339677',
            'avatar' => '/img/nopic.jpg',
            'last_at' => '2019-05-20',
            'last_ip' => '127.0.0.1',
            'login_times' => '0',
            'passed' => 1,
            'desc' => '系统用户',
			'is_system' => '1'
        ]]);
        DB::table('accounts')->insert([[
            'name' => 'admin',  
			'password' => Hash::make('admin888'),			
            'user_id' => 1,
            'passed' => 1,
			'type' => 0
        ],[
            'name' => '15113339677',  
			'password' => '',			
            'user_id' => 1,
            'passed' => 1,
			'type' => 1
        ],[
            'name' => 'wx8ccff2986bb253a7',  
			'password' => '0',			
            'user_id' => 1,
            'passed' => 1,
			'type' => 2
        ]]);
		
		/*权限模块*/
        DB::table('accesses')->insert([[
			'id' => '1',
			'parent_id' => '0',
            'name' => '用户管理', 
            'code' => 'safe', 
            'desc' => '',
            'path' => '/member/user'
        ],[
			'id' => '2',
			'parent_id' => '1',
            'name' => '添加用户', 
            'code' => 'user', 
            'desc' => '',
            'path' => '/member/user',
        ],[
			'id' => '3',
			'parent_id' => '1',
            'name' => '修改用户', 
            'code' => 'role', 
            'desc' => '',
            'path' => '/member/user'
        ],[
			'id' => '4',
			'parent_id' => '1',
            'name' => '删除用户', 
            'code' => 'role', 
            'desc' => '',
            'path' => '/member/user'
        ],[
			'id' => '5',
			'parent_id' => '0',
            'name' => '角色管理', 
            'code' => '', 
            'desc' => '',
            'path' => '/member/role'
        ],[
			'id' => '6',
			'parent_id' => '5',
            'name' => '添加角色', 
            'code' => '', 
            'desc' => '',
            'path' => '/member/role'
        ],[
			'id' => '7',
			'parent_id' => '5',
            'name' => '修改角色', 
            'code' => 'role', 
            'desc' => '',
            'path' => '/member/role'
        ],[
			'id' => '8',
			'parent_id' => '5',
            'name' => '删除角色', 
            'code' => 'role', 
            'desc' => '',
            'path' => '/member/user'
        ],[
			'id' => '9',
			'parent_id' => '0',
            'name' => '菜单管理', 
            'code' => '', 
            'desc' => '',
            'path' => '/member/role'
        ],[
			'id' => '10',
			'parent_id' => '9',
            'name' => '添加菜单', 
            'code' => '', 
            'desc' => '',
            'path' => '/member/role'
        ],[
			'id' => '11',
			'parent_id' => '9',
            'name' => '修改菜单', 
            'code' => 'role', 
            'desc' => '',
            'path' => '/member/role'
        ],[
			'id' => '12',
			'parent_id' => '9',
            'name' => '删除菜单', 
            'code' => 'role', 
            'desc' => '',
            'path' => '/member/user'
        ],[
			'id' => '13',
			'parent_id' => '0',
            'name' => '权限查看',
            'code' => 'role', 
            'desc' => '',
            'path' => '/system/access'
        ]]);
		
		/*菜单管理*/
        DB::table('menus')->insert([[
			'id' => '1',
			'parent_id' => '0',			
			'name' => '权限管理',
            'prefix' => '/', 
            'path' => '',
            'icon' => '',   
            'target' => '_self', 
            'is_system' => '1'
        ],[
			'id' => '2',
			'parent_id' => '1',			
			'name' => '系统用户',
            'prefix' => '/', 
            'path' => 'member/user',
            'icon' => '',   
            'target' => '_self', 
            'is_system' => '1'
        ],[
			'id' => '3',
			'parent_id' => '1',			
			'name' => '角色信息',
            'prefix' => '/', 
            'path' => 'member/role',
            'icon' => '',   
            'target' => '_self', 
            'is_system' => '1'
        ],[
			'id' => '4',
			'parent_id' => '0',			
			'name' => '系统设置',
            'prefix' => '/', 
            'path' => '',
            'icon' => '',   
            'target' => '_self', 
            'is_system' => '1'
        ],[
			'id' => '5',
			'parent_id' => '4',			
			'name' => '站点配置',
            'prefix' => '/', 
            'path' => 'setting/config',
            'icon' => '',   
            'target' => '_self', 
            'is_system' => '1'
        ],[
			'id' => '6',
			'parent_id' => '4',			
			'name' => '菜单资源',
            'prefix' => '/', 
            'path' => 'setting/menus/index',
            'icon' => '',   
            'target' => '_self', 
            'is_system' => '1'
        ],[
			'id' => '7',
			'parent_id' => '4',			
			'name' => '访问权限',
            'prefix' => '/', 
            'path' => 'setting/access/index',
            'icon' => '',   
            'target' => '_self', 
            'is_system' => '1'
        ]]);
		
		
		/*权限模块*/
        DB::table('configs')->insert([[		
            'name' => '网站名', 
            'key' => 'app.name', 
            'value' => '扫地机器人', 
            'default_value' => '扫地机器人', 
            'option_value' => '', 
            'help' => '请输入站点名', 
            'field_type' => 'text',
            'sort' => 0,
            'is_private' => 0, 
            'is_public' => 0, 
			'group_label' => '系统',
			'group_name' => 'system'
		],[		
            'name' => 'DEBUG', 
            'key' => 'app.debug', 
            'value' => '0', 
            'default_value' => '0', 
            'option_value' => '', 
            'help' => '', 
            'field_type' => 'switch',
            'sort' => 1,
            'is_private' => 0, 
            'is_public' => 0, 
			'group_label' => '系统',
			'group_name' => 'system'
		],[		
            'name' => '网站地址', 
            'key' => 'app.url', 
            'value' => '', 
            'default_value' => '#', 
            'option_value' => '', 
            'help' => '', 
            'field_type' => 'text',
            'sort' => 2,
            'is_private' => 0, 
            'is_public' => 0, 
			'group_label' => '系统',
			'group_name' => 'system'
		],[		
            'name' => '网站logo', 
            'key' => 'app.logo', 
            'value' => '', 
            'default_value' => '', 
            'option_value' => '', 
            'help' => '', 
            'field_type' => 'image',
            'sort' => 3,
            'is_private' => 0, 
            'is_public' => 0, 
			'group_label' => '系统',
			'group_name' => 'system'
		],[		
            'name' => '关于我们', 
            'key' => 'app.desc', 
            'value' => '', 
            'default_value' => '', 
            'option_value' => '', 
            'help' => '', 
            'field_type' => 'longtext',
            'sort' => 3,
            'is_private' => 0, 
            'is_public' => 0, 
			'group_label' => '系统',
			'group_name' => 'system'
		]]);
    }
}
