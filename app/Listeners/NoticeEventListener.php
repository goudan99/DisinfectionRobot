<?php
/*
生成用户操作日志
*/
namespace App\Listeners;
use Log;
use App\Events\UploadShared;
use App\Model\Notice;

class NoticeEventListener
{	

    /**
     * 为订阅者注册监听器
     *
     * @param  Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
		$events->listen(UploadShared::class,NoticeEventListener::class.'@onUploadShare');
    }

    /**
     * Handle the event.
     * 尝试成功
     * @param  Login  $event
     * @return void
     */
	public function onUploadShare($event)
	{
		$data=[];
		
		if($user=$event->notify["form"]["user"]){$data["form_id"]=$user->id;}
		
		$data["title"]=$event->data["remark"];
		
		$data["content"]=json_encode($event->data["pics"]);

		foreach($event->data["users"] as $item){
			$data["user_id"]=$item["user_id"];
			Notice::create($data);
		}
	}
}
