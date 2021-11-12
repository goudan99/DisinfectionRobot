<?php
namespace App\Repositories;
use Illuminate\Support\Facades\Hash;
use App\Model\Account as accountModel;
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
use Illuminate\Validation\ValidationException;
use DB;

class User implements Repository
{
	/**
	 *
	 * 保存用户,把修改或添加用户传递下一层是那些用户进行了添国或修改过
	 * 传递数据若带有用户id则是修改用户信息
	 *
	 * @param array $data 用户信息
	 * @param array $notify  附近加信息，from 主要是来源于谁,为空时时系统内部发生的
	 * @return boolen
	 */
	public function store($data,$notify){
		
		$data["roles"]= new Collection($data['roles']);
		
		if(!$roles=roleModel::whereIn('id',$data['roles'])->get('id')){
            throw ValidationException::withMessages([
              "roles" => "角色不存在",
            ]);
		}
		
		$data['password']?$data['password']=Hash::make($data['password']):'';

		if(isset($data['id'])&&$data['id']){
			DB::transaction(function () use ($data,$notify){
				if(!$user=userModel::where("id",$data['id'])->first()){throw new NotFoundException("用户不存在");}
				unset($data['code']);
				if(!$data['password']){unset($data['password']);}
				$user->update($data);
				if(!$user->is_system==1){$user->roles()->sync($data['roles']);}
				if(isset($data['phone'])&&$account=accountModel::where('user_id',$data['id'])->where('type',1)->first()){
					$account->name=$data['phone'];
					isset($data['password'])?$account->password=$data['password']:'';
					$account->update();
					$notify["method"]="edit";					
					event(new UserStored($user,$notify));
					return true;
				}
				
			});
			
			return true ;
		
		}
		
		if(accountModel::where("name",$data['phone'])->first()){
            throw ValidationException::withMessages(["phone" => "已存在同的手机"]);
		}
		
		if(!$data['password']){
            throw ValidationException::withMessages(["password" => "密码不能空"]);
		}
		
		DB::transaction(function () use ($data,$notify){
			
			$data['company_id']=$notify["form"]["user"]->company_id;
			
			$user=userModel::create($data);
			
			$account=accountModel::create([
				"name"=>$data['phone'],
				"password"=>$data['password'],
				"user_id"=>$user->id,
				"type"=>1
			]);
			
			if(!$user->is_system==1){
			  $user->roles()->sync($data['roles']);
			}
			
			$notify["method"]="add";

			event(new UserStored($user,$notify));
		});
		
		return true ;
	}
	
	/**
	 * 删除用户,此功能删除用户，系统用户不允许删除，把要删除的用户告诉事件删掉了那些用户
	 * @param array $data [1,2]要删除的用户id
	 * @param array $notify  附近加信息，from 主要是来源于谁,为空时时系统内部发生的
	 * @return boolen
	 */
	public function remove($data,$notify)
	{
		$users=userModel::whereIn("id",$data)->where('is_system','<>',1)->get();//把用户查询出来,为了要告诉下一层删除了那一些用户
		
		if(userModel::whereIn("id",$data)->where('is_system','<>',1)->delete()){accountModel::whereIn("user_id",$data)->delete();}
		
		event(new UserRemoved($users,$notify));
		  
		return true;
	}
}
