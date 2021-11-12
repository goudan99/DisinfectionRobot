<?php
namespace App\Repositories;
use Illuminate\Support\Facades\Hash;
use App\Model\Machine as machineModel;
use App\Model\Map as MapModel;
use App\Events\MapStored;
use App\Events\MapRemoved;
use App\Exceptions\AttachException;
use App\Exceptions\UniqueException;
use App\Exceptions\NotFoundException;
use App\Exceptions\AuthException;
use App\Model\Machine;
use App\Model\User;
use Illuminate\Validation\ValidationException;

class Map implements Repository
{
	/*保存机器*/
	public function store($data,$notify){
		
        if($data["user_id"]){
			if($user=User::where('id',$data["user_id"])->first()){
				$data['user_name']=$user->phone;
			}
		}
		
        if($data["machine_id"]){
			if($machine=Machine::where('id',$data["machine_id"])->first()){$data['machine_name']=$machine->sn;}
			
			$user=$notify["form"]["user"];
			if(!($user->id==1||$user->roles()->where('level',1)->first())){
				if(!$notify["form"]["user"]->machines()->where("id",$data["machine_id"])->first()){
					throw ValidationException::withMessages(["machine_id" => "该机器不存在，或者你没有权限操控此机器"]);
				}
			}
		}
		
		if(isset($data['id'])&&$data['id']){
			
			if(!$user=MapModel::where("id",$data['id'])->first()){
				throw new NotFoundException("地图不存在");
			}
			$user->update($data);
			$notify["method"]="edit";
			event(new MapStored($user,$notify));
			return true ;
		}

		$user=MapModel::create($data);
			
		$notify["method"]="add";
		
		event(new MapStored($user,$notify));
		
		return true ;
	}
	
	/*删除用户*/
	public function remove($data,$notify)
	{
		$maps=MapModel::whereIn("id",$data);
		
		$user=$notify["form"]["user"];
		
		if(!($user->id==1||$user->roles()->where('level',1)->first())){
			
			$machines=[];
			
			foreach($user->machines()->get(["id"]) as $item){ array_push($machines,$item->id);}
			
			$maps=$maps->whereIn('machine_id',$machines);
		}

		if(!$maps->get()->toArray()){throw ValidationException::withMessages(["machine_id" => "该任务不存在，或者你没有权限操控此任务"]);}
		
		MapModel::whereIn("id",$data)->delete();
		
		event(new MapRemoved($maps,$notify));
		  
		return $maps;
	}
}
