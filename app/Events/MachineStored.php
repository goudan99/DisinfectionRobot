<?php
namespace App\Events;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
/*
机器保存
*/
class MachineStored
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
	
	public $data;
	
	public $notify;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data,$notify=null)
    {
		
		$this->data=$data;
		
		$this->notify=$notify;
    }
}
