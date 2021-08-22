<?php
namespace App\Repositories;
use App\Events\LogRemoved;
use App\Events\LogStored;
use App\Model\Access;

class AccessReposity implements Repository
{
	public function store($data,$notify){
		
		if($data["id"]&&$access=Access::where("id",$data["id"])->first()){
			$access->fill($data);
			return $access->save();
		}
		
		if($access=Access::where("path",$data["path"])->where("method",$data["method"])->first()){
			$access->fill($data);
			return $access->save();
		}
		
		return Access::create($data);
		
	}
	public function remove($id,$notify)	{
	  return Access::where("id",$id)->delete();
	}
	public function uri($data,$notify=[])	{
		return $data;
	}
}
