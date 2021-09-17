<?php
/*
生成用户操作日志
*/
namespace App\Listeners;
use Log;
use App\Events\AccessRemoved;
use App\Events\AccessStored;
use App\Events\ConfigStored;
use App\Events\LogRemoved;
use App\Events\LogStored;
use App\Events\MachineRemoved;
use App\Events\MachineStored;
use App\Events\MenuRemoved;
use App\Events\MenuStored;
use App\Events\NoticeChanged;
use App\Events\RoleRemoved;
use App\Events\RoleStored;
use App\Events\UploadStored;
use App\Events\UserRemoved;
use App\Events\UserStored;
use App\Model\LoggerUser;

class LogEventListener
{	

    /**
     * 为订阅者注册监听器
     *
     * @param  Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
		$events->listen(AccessRemoved::class,LogEventListener::class.'@onDataRemove');
		$events->listen(AccessStored::class,LogEventListener::class.'@onStroeSuccess');
		$events->listen(ConfigStored::class,LogEventListener::class.'@onStroeSuccess');
		$events->listen(LogRemoved::class,LogEventListener::class.'@onDataRemove');
		$events->listen(LogStored::class,LogEventListener::class.'@onStroeSuccess');
		$events->listen(MachineRemoved::class,LogEventListener::class.'@onDataRemove');
		$events->listen(MachineStored::class,LogEventListener::class.'@onStroeSuccess');
		$events->listen(MenuRemoved::class,LogEventListener::class.'@onDataRemove');
		$events->listen(MenuStored::class,LogEventListener::class.'@onStroeSuccess');
		$events->listen(RoleRemoved::class,LogEventListener::class.'@onDataRemove');
		$events->listen(RoleStored::class,LogEventListener::class.'@onStroeSuccess');
		$events->listen(UserRemoved::class,LogEventListener::class.'@onDataRemove');
		$events->listen(UserStored::class,LogEventListener::class.'@onStroeSuccess');
		//$events->listen(UploadStored::class,LogEventListener::class.'@onStroeSuccess');
    }
	
    /**
     * Handle the event.
     * 尝试成功
     * @param  Login  $event
     * @return void
     */
	public function onDataRemove($event)
	{		
		if($user=$event->notify["form"]["user"]){
			
			$data["user_id"]=$user->id;
			$data["user_name"]=$user->name;
		}
		
		$data["content"]="删除";
		
		if($event->data instanceof \App\Model\Menu){
			$data["content"]=$data["content"]."菜单";
		}
		
		if($event->data instanceof \App\Model\User){
			$data["content"]=$data["content"]."系统用户";
		}
		
		if($event->data instanceof \App\Model\Role){
			$data["content"]=$data["content"]."系统角色";
		}
		
		if($event->data instanceof \App\Model\ConfigS){
			$data["content"]=$data["content"]."系统配置";
		}
		
		if($event->data instanceof \App\Model\Access){
			$data["content"]=$data["content"]."系统权限";
		}
		
		if($event->data instanceof \App\Model\Machine){
			$data["content"]=$data["content"]."设备";
		}
		
		$data["data"]=$event->data->id;
		
		LoggerUser::create($data);
	}
    /**
     * Handle the event.
     * 尝试成功
     * @param  Login  $event
     * @return void
     */
	public function onStroeSuccess($event)
	{		
		if($user=$event->notify["form"]["user"]){
			
			$data["user_id"]=$user->id;
			$data["user_name"]=$user->name;
		}
		if($user=$event->notify["method"]=="edit"){
			
			$data["content"]="修改";
		}else{
			$data["content"]="添加";
		}
		
		if($event->data instanceof \App\Model\Menu){
			$data["content"]=$data["content"]."菜单";
		}
		
		if($event->data instanceof \App\Model\User){
			$data["content"]=$data["content"]."系统用户";
		}
		
		if($event->data instanceof \App\Model\Role){
			$data["content"]=$data["content"]."系统角色";
		}
		
		if($event->data instanceof \App\Model\ConfigS){
			$data["content"]=$data["content"]."系统配置";
		}
		
		if($event->data instanceof \App\Model\Access){
			$data["content"]=$data["content"]."系统权限";
		}
		
		if($event->data instanceof \App\Model\Machine){
			$data["content"]=$data["content"]."设备";
		}
		
		LoggerUser::create($data);
	}
}
