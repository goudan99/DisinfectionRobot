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
		
		if(isset($data['id'])&&$data['id']){
			
			if(!$user=machineModel::where("id",$data['id'])->first()){
				throw new NotFoundException("机器不存在");
			}
			
			$user->update($data);
			
			$notify["method"]="edit";
			
			event(new MachineStored($user,$notify));
			return true ;
		}
			
		if(machineModel::where("sn",$data['sn'])->first()){
			throw new UniqueException("该机器已经添加过了");
		}
			
		$user=machineModel::create($data);
			
		$notify["method"]="add";
		
		event(new MachineStored($user,$notify));
		
		return true ;
	}
	
	/*删除用户*/
	public function remove($data,$notify)
	{
		$users=machineModel::whereIn("id",$data)->get();
		
		machineModel::whereIn("id",$data)->delete();
		
		event(new MachineRemoved($users,$notify));
		  
		return $users;
	}
}
