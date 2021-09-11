<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/',function(){ return abort(404); });

Route::group(['namespace' =>"Admin", 'prefix' => 'auth'], function ($router){
	
	Route::post('/login/token', 	'AuthController@login')->name('login');
	
	Route::any('/login/logout', 	'AuthController@logout')->name('logout');
	
	Route::post('/find/password',	'AuthController@password');
	
	Route::any('/find/code',		'AuthController@code');
});

Route::group(['namespace' =>"Admin", 'prefix' => 'profile','middleware' => ['auth:api']], function () {
	Route::get('/user','ProfileController@user');
	Route::post('/user/code','ProfileController@code');
	Route::get('/user/{id?}','ProfileController@show');
	Route::post('/user','ProfileController@store');
	Route::post('/avatar','ProfileController@avatar');
	Route::post('/password','ProfileController@password');
	Route::post('/phone','ProfileController@phone');
	Route::get('/menu','ProfileController@menu');
	Route::get('/notice','ProfileController@notice');
	Route::get('/notice/{id?}','ProfileController@show');
	Route::put('/notice/{id?}','ProfileController@read');//标志已读
	Route::patch('/notice/{id?}','ProfileController@restore');//恢复删除
	Route::delete('/notice/{id?}','ProfileController@remove');//删除
	Route::get('/notice/unread','ProfileController@remove');//没有读的条数

});

/*权限管理模块*/
Route::group(['namespace' =>"Admin", 'prefix' => 'member','middleware' => ['auth:api','permit:api']], function () {
	Route::get('/user','UserController@home');
	Route::get('/user/{id}','UserController@show');
	Route::post('/user','UserController@store');
	Route::put('/user','UserController@store');
	Route::delete('/user','UserController@remove');
	
	Route::get('/role','RoleController@home');
	Route::get('/role/{id?}','RoleController@show');
	Route::post('/role','RoleController@store');
	Route::put('/role','RoleController@store');
	Route::delete('/role','RoleController@remove');
});


/* 机器管理 */
Route::group(['namespace' =>"Admin", 'prefix' => 'machine','middleware' => ['auth:api','permit:api']], function () {
	Route::get('/machine','MachineController@home');
	Route::get('/machine/{id?}','MachineController@show');
	Route::post('/machine','MachineController@store');
	Route::delete('/machine','MachineController@remove');
});

/*配置模块-菜单配置,config配置*/
Route::group(['namespace' =>"Admin", 'prefix' => 'setting','middleware' => ['auth:api','permit:api']], function () {
	Route::get('/menus','MenuController@home');
	Route::get('/menus/{id?}','MenuController@show');
	Route::post('/menus','MenuController@store');
	Route::put('/menus','MenuController@store');
	Route::delete('/menus','MenuController@remove');
	Route::get('/menus/{id?}/action','MenuController@action');
	Route::post('/menus/{id?}/action','MenuController@storeAction');
	Route::delete('/menus/{id?}/action','MenuController@delAction');
	Route::get('/config','SettingController@config');
	Route::post('/config','SettingController@store');
	Route::post('/config/upload','SettingController@upload');
});

/*系统-消息,所有权限列表,日志归为系统类*/
Route::group(['namespace' =>"Admin", 'prefix' => 'system','middleware' => ['auth:api','permit:api']], function () {
	Route::get('/access','AccessController@home');
	Route::post('/access','AccessController@store');
	Route::delete('/access/{id?}','AccessController@remove');
	Route::get('/uris','AccessController@uri');
	Route::get('/logger/api','LoggerController@api');   				//显示前端错误
	Route::get('/logger/code','LoggerController@code');					//获取后端报错
	Route::get('/logger/code/{id?}','LoggerController@codeShow');		//显示后端错误
	Route::delete('/logger/code/{id?}','LoggerController@codeRemove');	//删除错误日志
	Route::get('/logger/job','LoggerController@job');   				//任务日志
	Route::get('/logger/user','LoggerController@user');   				//用户操作日志
});
Route::group(['namespace' =>"Admin", 'prefix' => 'system','middleware' => []], function () {
	Route::post('/logger/api','LoggerController@store');				//上传前端错误
});