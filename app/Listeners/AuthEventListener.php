<?php
namespace App\Listeners;
use Log;
use Illuminate\Auth\Events\Login; // 登录成功时 --参数为$user, $remember
use Illuminate\Auth\Events\Attempting; //尝试登录 --参数为 credentials remember
use Illuminate\Auth\Events\Authenticated; //每次拿去用户授权信息时 参数为user
use Illuminate\Auth\Events\Failed; //登录失败时 --参数为 $user, $credentials

class AuthEventListener
{	

    /**
     * 为订阅者注册监听器
     *
     * @param  Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
		$events->listen(Login::class,AuthEventListener::class.'@onLoginSuccess');//登录成功
		
		$events->listen(Attempting::class,AuthEventListener::class.'@onAttempting');//尝试登录
		
		$events->listen(Authenticated::class,AuthEventListener::class.'@onAuthenteSuccess');//验证成功
    }
	
    /**
     * Handle the event.
     * 尝试成功
     * @param  Login  $event
     * @return void
     */
	public function onAttempting($event)
	{		
			
		//print_r($event);
	}
    /**
     * Handle the event.
     * 尝试成功
     * @param  Login  $event
     * @return void
     */
	public function onAuthenteSuccess($event)
	{		
			
		//print_r($event);
	}
	
    /**
     * Handle the event.
     * 登录成功
     * @param  Login  $event
     * @return void
     */
	public function onLoginSuccess($event)
	{
		$event->user->user->last_at=date('Y-m-d H:i:s', time());
		
		$event->user->user->login_times=$event->user->login_times+1;
		
		$event->user->user->save();
	}
}
