<?php
/*
生成用户操作日志
*/
namespace App\Listeners;
use Log;
use App\Events\UserStored;
use App\Events\RoleStored;
use App\Events\AccessStored;
use App\Events\MenuStored;

use App\Model\Invite;
use Illuminate\Auth\Events\Registered;

use App\Events\MachineStored;
use App\Events\MapStored;
use App\Events\JobStored;

use App\Events\FreedbackSended;
use App\Events\NoticeSended;

class CompanyEventListener
{	

    /**
     * 为订阅者注册监听器
     *
     * @param  Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
		/*系统类*/
		$events->listen(UserStored::class,CompanyEventListener::class.'@onCreatedShare');
		$events->listen(RoleStored::class,CompanyEventListener::class.'@onCreatedShare');
		$events->listen(AccessStored::class,CompanyEventListener::class.'@onCreatedShare');
		$events->listen(MenuStored::class,CompanyEventListener::class.'@onCreatedShare');
		$events->listen(Registered::class,CompanyEventListener::class.'@onRegistered');
		$events->listen(Registered::class,CompanyEventListener::class.'@onRegistered');
		/*业务相关*/
		$events->listen(MachineStored::class,CompanyEventListener::class.'@onCreatedShare');
		$events->listen(MapStored::class,CompanyEventListener::class.'@onCreatedShare');
		$events->listen(JobStored::class,CompanyEventListener::class.'@onCreatedShare');
		
		/*消息相关*/
		$events->listen(FreedbackSended::class,CompanyEventListener::class.'@onCreatedShare');
		$events->listen(NoticeSended::class,CompanyEventListener::class.'@onCreatedShare');
    }

    /**
     * Handle the event.
     * 尝试成功
     * @param  Login  $event
     * @return void
     */
	public function onCreatedShare($event)
	{
		
		$data=$event->data;
		
		$form=$event->notify["form"]["user"];

		if($data&&$form&&$event->notify["method"]=="add"){
			
			$data->company_id=$form->company_id;
			
			$data->save();
			
			if($invite=Invite::where("code",$data->code)->first()){
				
				$invite->user_id=$data->id;
				
				$invite->status=1;
				
				$invite->save();
			}
		}
	}
	
    /**
     * Handle the event.
     * 用户注册时
     * @param  Login  $event
     * @return void
     */
	public function onRegistered($event)
	{

		$data=$event->user;
		
		if($invite=Invite::where("code",$data->code)->first()){
				
			$invite->user_id=$data->id;
				
			$invite->status=1;
				
			$invite->save();
		}
	}
}
