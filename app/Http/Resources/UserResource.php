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
		 return [
           'id' => $this->id,
           'name' => $this->name,
           'nickname' => $this->nickname,
           'phone' => $this->phone,	
           'avatar' => $this->avatar,
           'role_id' => $this->role_id,	
           'role_name' => $this->role_name,
           'last_at' => $this->last_at,	
           'last_ip' => $this->last_ip,
           'login_times' => $this->login_times,	
           'passed' => $this->passed,
		   'is_system' => $this->is_system,
           'created_at' => $this->created_at,
           'updated_at' => $this->updated_at
        ];
    }
}
