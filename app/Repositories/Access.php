<?php
namespace App\Repositories;
use App\Events\AccessRemoved;
use App\Events\AccessStored;
use App\Model\Access as AccessModel;
use App\Exceptions\ValidationException;

class Access implements Repository
{
	public function store($data,$notify){
		
		if($data["id"]&&$access=AccessModel::where("id",$data["id"])->first()){
			
			if($data['parent_id']==$data['id']){
				throw new ValidationException("不能把自己设为依赖于自己");
			}
			
			if($data['parent_id']&&$acc2=AccessModel::where("id",$data["parent_id"])->first()){
				
				if($acc2["parent_id"]==$access->id){
					throw new ValidationException("不能把自己设为依赖于自己下面的子功能");
				}
			}
			$notify["method"]="edit";

			$access->fill($data);
			
			$access->save();
			
			event(new AccessStored($access,$notify));
			
			return true;
		}
		
		if($access=AccessModel::where("path",$data["path"])->where("method",$data["method"])->first()){
			
			$access->fill($data);
			
			$notify["method"]="edit";
			
			$access->save();
			
			event(new AccessStored($access,$notify));
			
			return true;
		}
		
		
		$notify["method"]="add";
		
		$access=AccessModel::create($data);

		event(new AccessStored($access,$notify));
		
		return true;
		
	}
	public function remove($id,$notify)	{
		
	  if(!$access=AccessModel::where("id",$id)->first()){
		return true;
	  }
	  
	  $access->menus()->detach();//菜单id
	  
	  $access->roles()->detach();//角色id
	  
	  $access->delete();
	  
	  AccessModel::where("parent_id",$id)->delete();
	  
      $notify["method"]="remove";
		
      event(new AccessRemoved($access,$notify));
		
	  return true;

	}
	public function uri($data,$notify=[])	{
		return $data;
	}
}
