<?php
namespace App\Repositories;
use App\Model\User as userModel;
use App\Model\Upload as uploadModel;
use collect;

class Upload implements Repository
{
	public function store($data,$notify){}
	
	public function share($data,$notify){
		
		$arr1=[];
		
		foreach(userModel::whereIn("id",$data["users"])->get() as $item){array_push($arr1,["user_id"=>$item->id,"user_name"=>$item->phone,"remark"=>$data['remark']]);}
		
		$arr2=[];
		
		foreach(uploadModel::whereIn("id",$data["pics"])->where('user_id',$notify["form"]["user"]->id)->get() as $item){array_push($arr2,["url"=>$item->url,"from_type"=>1,"from_id"=>$notify["form"]["user"]->id]);}
		
		$collection = collect($arr1);

		$matrix = $collection->crossJoin($arr2);

		$arr=$matrix->map(function ($item) {return array_merge($item[0],$item[1]);})->toArray();

		foreach($arr as $item){
			uploadModel::create($item);
		}
	}
	
	public function remove($data,$notify)	{
		
		uploadModel::whereIn("id",$data)->where('user_id',$notify["form"]["user"]->id)->delete();

		return true;
	}
	
}
