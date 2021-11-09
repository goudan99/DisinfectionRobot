<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    public function toArray($request)
    {
		$user = $request->user("api");
		
		$machine=$user->user->id==1?$this->machine:$user->user->machines()->where('id',$this->machine_id)->first();
		
		 $data=[
           'id' => $this->id,
           'name' => $this->name,
           'user_id' => $this->user?$this->user->id:$this->user_id,
           'user_name' => $this->user?$this->user->name:$this->user_name,
           'machine_id' => $machine?$machine->id:$this->machine_id,
           'machine_sn' => $machine?$machine->sn:$this->machine_sn,
           'machine_name' => $machine?$machine->name:$this->machine_name,
           'map_id' => $this->map?$this->map->id: $this->map_id,
           'map_name' => $this->map?$this->map->name:$this->map_name,
           'map_area' => $this->map_area,
           'rate_type' => $this->rate_type,
           'work' => $this->work,
           'is_clean' => $this->is_clean,
           'is_test' => $this->is_test,
           'start_at' => $this->start_at,
           'end_at' => $this->end_at,
           'type_id' => $this->type_id,
           'status' => $this->status,	
           'created_at' => $this->created_at,
           'updated_at' => $this->updated_at
        ];
		return $data;
    }
}
