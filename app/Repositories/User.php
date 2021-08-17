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

class User implements Repository
{
	/*保存用户*/
	public function store($data,$notify){
		
		if(!$role=roleModel::where('id',$data['role_id'])->first()){
			throw new AttachException("角色不存在");
		}

		$data['role_name']=$role->name;
		
		$data['password']?$data['password']=Hash::make($data['password']):'';

		if(isset($data['id'])&&$data['id']){
			
			if(!$user=userModel::where("id",$data['id'])->first()){
				throw new NotFoundException("用户不存在");
			}

			$user->update($data);
			
			$notify["method"]="edit";
			
			event(new UserStored($user,$notify));
		
			return true ;
		
		}
			
		if(userModel::where("name",$data['name'])->first()){
			throw new UniqueException("已存在同名用户");
		}
			
		$user=userModel::create($data);
			
		$notify["method"]="add";
		
		event(new UserStored($user,$notify));
		
		return true ;
	}
	
	/*删除用户*/
	public function remove($id,$notify)
	{
		$user=userModel::where("id",$id)->first()
		
		if(!$user){throw true;}
		
		if($user->is_system==1){
			throw new AuthException("系统用户不允许删除");
		}
		
		$user->delete();
		  
		event(new UserRemoved($user,$notify));
		  
		return $user;
	}
}
