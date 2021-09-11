<?php
namespace App\Repositories;
use App\Events\AccessRemoved;
use App\Events\AccessStored;
use App\Model\Access as AccessModel;
use App\Exceptions\ValidationException;
use App\Model\User;
use Illuminate\Support\Facades\Hash;

class Auth implements Repository
{
	public function store($data,$notify){}
	
	public function remove($id,$notify)	{}
	
	//发送验证码
	public function change($data,$notify=[])	{
		
		$user=User::where('phone',$data['phone'])->first();
		
		$user->password=Hash::make($data["password"]);
		
		$user->save();
		
		return true;
		
	}
	
}
