<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    public function toArray($request)
    {
		$user = $request->user("api");
		$machine_name=$this->machine_name;
		$machine_sn="";	
		if($user->user->roles()->where("level",1)->first()||$user->user>user->id==1){
			$machineobj = Machine::orderBy('id','desc');
			$machine=$machineobj->where('id',$this->machine_id)->first();
			if($machine){
				$machine_name=$machine->name;
				$machine_sn=$machine->sn;
			}
		}else{
			$machineobj = $user->user->machines()->orderBy('id','desc');
			$machine=$machineobj->where('id',$this->machine_id)->first();
			if($machine){
				$machine_name=$machine->pivot->machine_name;
				$machine_sn=$machine->sn;
			}
		}
			
		 $data=[
           'id' => $this->id,
           'name' => $this->name,
           'user_id' => $this->user?$this->user->id:$this->user_id,
           'user_name' => $this->user?$this->user->phone:$this->user_name,
           'machine_id' => $machine?$machine->id:$this->machine_id,
           'machine_sn' => $machine_sn,
           'machine_name' => $machine_name,
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
