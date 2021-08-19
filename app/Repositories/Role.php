<?php
namespace App\Repositories;
use App\Model\Role as RoleModel;
use App\Events\RoleStored;
use App\Events\RoleRemoved;
use App\Exceptions\AttachException;
use App\Exceptions\UniqueException;
use App\Exceptions\NotFoundException;
use App\Exceptions\AuthException;

class Role implements Repository
{
	/***
	保存角色
	***/
	public function store($data,$notify){
		
		$role_data=[
			'name' => $data['name'],
			'status' => $data['status'],
			'desc' => isset($data['desc'])?$data['desc']:''
		];
		
		if(isset($data['id'])&&$data['id']){
			
			if(!$role=RoleModel::where("id",$data['id'])->first()){
				throw new NotFoundException("角色不存在");
			}
			
			$role->update($role_data);
			
			if(!$role->is_system==1){
				$role->access()->sync($data["access"]);
			}
			
			$notify["method"]="edit";
			
			event(new RoleStored($role,$notify));
		
			return true ;
			
		}
		
		$role=RoleModel::where("name",$role_data['name'])->first();
		
		if($role){
			throw new UniqueException("已经存在相同名的角色");
		}
		
		$role=RoleModel::create($role_data);
		
		$role->access()->sync($data["access"]);
		
		$notify["method"]="add";
		
		event(new RoleStored($role,$notify));
		
		return true ;
	}
	
	/*删除角色*/
	public function remove($id,$notify)
	{
		$role=RoleModel::where("id",$id)->first();
		
		if(!$role){return true;}
		
		if($role->is_system==1){
          throw new AuthException("系统角色不允许删除");
		}
		
		$role->delete();
		  
		$notify["method"]="remove";
		  
		event(new RoleRemoved($role,$notify));
		  
		return true;
	}
}
