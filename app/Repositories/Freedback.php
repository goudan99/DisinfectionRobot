<?php
namespace App\Repositories;
use App\Model\Freedback as freedbackModel;
use Storage;
use App\Events\FreedbackSended;
use App\Events\FreedbackRemoved;
use App\Events\UploadStored;
use Illuminate\Validation\ValidationException;

class Freedback implements Repository
{
	
	/*保存用户*/
	public function store($data,$notify){
		
		$notice=freedbackModel::create($data);
	
		$notify["method"]="add";
		
		event(new FreedbackSended($notice,$notify));
		
		return $notice;
	}
	
	
	/*上传反馈图片*/
	public function upload($request,$notify)
	{

      if (!$request->hasFile('file')) {return false;}
	  
	  $path=$request->file->store('freeback',config("robot")["freedback"]);

	  $url= config("filesystems")["disks"][config("robot")["freedback"]]["url"]."/". $path;
	  
	  event(new UploadStored(["path"=>$path,"url"=>$url],$notify));

	  return $url;
	}
	
	/*删除已读通知*/
	public function remove($data,$notify)
	{
		$machines=freedbackModel::whereIn("id",$data)->get();

		$user=$notify["form"]["user"];
		
		$notify["method"]="delete";
		
		if($user->id==1||$user->roles()->where('level',1)->first()){
			
			freedbackModel::whereIn("id",$data)->delete();
			
			event(new FreedbackRemoved($machines,$notify));
			
			return $machines;
		}

		freedbackModel::whereIn("id",$data)->delete();
		
		event(new FreedbackRemoved($machines,$notify));
		  
		return $machines;;
	}
}
