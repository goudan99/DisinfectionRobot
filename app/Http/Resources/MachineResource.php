<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\JsonResource;

class MachineResource extends JsonResource
{
    public function toArray($request)
    {
		 $data=[
           'id' => $this->id,
           'name' => $this->name,
           'sn' => $this->sn,
           'status' => $this->status,	
           'access' => $this->access,
           'macid' => $this->macid,
           'disinfect_num' => $this->disinfect_num,
           'move_speed' => $this->move_speed,	
           'job_status' => $this->job_status,
           'job_progress' => $this->job_progress,
           'power_num' => $this->power_num,
           'machine_area' => $this->machine_area,
           'work_area' => $this->work_area,
           'work_time' => $this->work_time,
           'work_num' => $this->work_num,	
           'cpu_tempe' => $this->cpu_tempe,
           'cpu_usage' => $this->cpu_usage,
           'hdd_usage' => $this->hdd_usage,
           'wifi_name' => $this->wifi_name,
           'wifi_stronge' => $this->wifi_stronge,
           'wifi_type' => $this->wifi_type,
           'wifi_ip' => $this->wifi_ip,
           'wifi_macid' => $this->wifi_macid,
           'created_at' => $this->created_at,
           'updated_at' => $this->updated_at
        ];
		if($this->pivot){
			$data['name']=$this->pivot->machine_name;
		}
		return $data;
    }
}
