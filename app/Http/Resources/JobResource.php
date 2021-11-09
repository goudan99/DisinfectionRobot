<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    public function toArray($request)
    {
		 $data=[
           'id' => $this->id,
           'name' => $this->name,
           'user_id' => $this->user->id,
           'user_name' => $this->user->name,
           'machine_id' => $this->machine->id,
           'machine_sn' => $this->machine->sn,
           'machine_name' => $this->machine->name,
           'map_id' => $this->map->id,
           'map_name' => $this->map->name,
           'map_area' => $this->map->area,
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
