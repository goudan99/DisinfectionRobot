<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
		$name="";
		
		if($data=$this->accounts->where('type',0)->first()){
			$name=$data->name;
		}
		if(!$name&&$data=$this->accounts->where('type',1)->first()){
			$name=$data->name;
		}
		$this->nickname=$this->nickname?$this->nickname:$name;
		//$name=$this->accounts->where('type',0)->first()?$this->accounts->where('type',0)->first()->name:$this->accounts->where('type',1)->first()?$this->accounts->where('type',1)->first()->name:'';
		 return [
           'id' => $this->id,
           'name' => $name,
           'nickname' => $this->nickname,
           'phone' => $this->phone,	
           'avatar' => $this->avatar,
           // 'role_id' => $this->role_id,	
		   'roles' => $this->roles,
           // 'role_name' => $this->role_name,
           'last_at' => $this->last_at,	
           'last_ip' => $this->last_ip,
           'login_times' => $this->login_times,	
           'passed' => $this->passed,
           'desc' => $this->desc,
		   'is_system' => $this->is_system,
           'created_at' => $this->created_at,
           'updated_at' => $this->updated_at
        ];
    }
}
