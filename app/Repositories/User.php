<?php
namespace App\Repositories;
use Illuminate\Support\Facades\Hash;
use App\Model\User as userModel;
use App\Model\Role as roleModel;
use App\Events\UserStored;
use App\Events\UserRemoved;
use App\Exceptions\AttachException;
use App\Exceptions\UniqueException;
use App\Exceptions\NotFoundException;
use App\Exceptions\AuthException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class User implements Repository
{
	/*保存用户*/
	public function store($data,$notify){
		
		
		$data["roles"]= new Collection($data['roles']);
		
		if(!$roles=roleModel::whereIn('id',$data['roles'])->get('id')){
			throw new AttachException("角色不存在");
		}
		
		$data['password']?$data['password']=Hash::make($data['password']):'';

		if(isset($data['id'])&&$data['id']){
			
			if(!$user=userModel::where("id",$data['id'])->first()){
				throw new NotFoundException("用户不存在");
			}
			
			unset($data['code']);//永远不有修改激活码
	        if(!$data['password']){
			  unset($data['password']);
			}
			
			$user->update($data);
			
			if(!$user->is_system==1){
				$user->roles()->sync($data['roles']);
			}

			$notify["method"]="edit";
			
			event(new UserStored($user,$notify));
		
			return true ;
		
		}
			
		if(userModel::where("name",$data['name'])->first()){
			throw new UniqueException("已存在同名用户");
		}
			
		$user=userModel::create($data);
			
	     if(!$user->is_system==1){
		  $user->roles()->sync($data['roles']);
		}
			
		$notify["method"]="add";
		
		event(new UserStored($user,$notify));
		
		return true ;
	}
	
	/*删除用户*/
	public function remove($data,$notify)
	{
		$users=userModel::whereIn("id",$data)->where('is_system','<>',1)->get();
		
		//if(!$user){return true;}
		foreach($users as $user){
		  if($user->is_system==1){
			throw new AuthException("系统用户不允许删除");
		  }	
		  $user->delete();
		}
		event(new UserRemoved($users,$notify));
		  
		return $users;
	}
}
