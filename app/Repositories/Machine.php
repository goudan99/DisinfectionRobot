<?php
namespace App\Repositories;
use Illuminate\Support\Facades\Hash;
use App\Model\Machine as machineModel;
use App\Model\Role as roleModel;
use App\Events\MachineStored;
use App\Events\MachineRemoved;
use App\Exceptions\AttachException;
use App\Exceptions\UniqueException;
use App\Exceptions\NotFoundException;
use App\Exceptions\AuthException;

class Machine implements Repository
{
	/*保存机器*/
	public function store($data,$notify){
		
		$user=$notify["form"]["user"];
		
		if(isset($data['id'])&&$data['id']){
			
			if($user->id==1||$user->roles()->where('level',1)->first()){
				$machine=machineModel::where("id",$data['id'])->first();
			}else{
				$machine=$user->machines()->where("id",$data['id'])->first();
			}
			
			if(!$machine){throw new NotFoundException("机器不存在");}
			
			$machine->update($data);
			
			$notify["method"]="edit";
			
			event(new MachineStored($machine,$notify));
			return true ;
		}
		if(!isset($data['sn'])){
			throw ValidationException::withMessages(["sn" => "sn不能为空"]);
		}
			
		if($machine=machineModel::where("sn",$data['sn'])->first()){
			if(!$machine->users()->where("user_id",$notify["form"]["user"]->id)->first()){
				$machine->users()->attach($notify["form"]["user"]->id,['machine_name' => $data['name']]);
			}else{
				throw new UniqueException("该机器已经添加过了");
			}
		}else{
			$machine=machineModel::create($data);
			$machine->users()->attach($notify["form"]["user"]->id,['machine_name' => $data['name']]);
		}
		
		$notify["method"]="add";
		
		event(new MachineStored($machine,$notify));
		
		return true ;
	}
	
	/*删除用户*/
	public function remove($data,$notify)
	{
		
		$machines=machineModel::whereIn("id",$data)->get();

		$user=$notify["form"]["user"];
		
		if($user->id==1||$user->roles()->where('level',1)->first()){
			machineModel::whereIn("id",$data)->delete();
			
			event(new MachineRemoved($machines,$notify));
			
			return $machines;
		}

		$notify["form"]["user"]->machines()->detach($data);
		
		event(new MachineRemoved($machines,$notify));
		  
		return $machines;
	}
}
