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

class Map implements Repository
{
	/*保存机器*/
	public function store($data,$notify){
		
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
		$maps=MapModel::whereIn("id",$data)->get();
		
		MapModel::whereIn("id",$data)->delete();
		
		event(new MapRemoved($maps,$notify));
		  
		return $maps;
	}
}
