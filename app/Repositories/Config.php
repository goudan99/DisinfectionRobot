<?php
namespace App\Repositories;
use Illuminate\Support\Facades\Hash;
use App\Model\Config as ConfigModel;
use App\Events\ConfigStored;
use App\Events\UploadStored;
use Storage;

class Config implements Repository
{
	/*修改配置文件*/
	public function store($data,$notify){
		
		foreach($data as $item)	{
			
			if(!$cinfig=ConfigModel::where("id",$item['id'])->first()){
				ConfigModel::create($item);
			}
			
			$cinfig->update($item);
		}
		
		$notify["method"]="edit";
			
		event(new ConfigStored($data,$notify));
		
		return true ;
	}
	
	/*上传图片*/
	public function upload($request,$notify){

      if (!$request->hasFile('file')) {
		return false;
	  }
	  
	  $path=$request->file->store(null,config("shop")["system"]);
	  
	  $url= url(Storage::disk(config("shop")["system"])->url($path));
	  
	  event(new UploadStored(["path"=>$path,"url"=>$url],$notify));

	  return $url;
	}
	
	/*修改配置文件*/
	public function show(){
		
	  $data=[];
	  $group=[];
	  $config=ConfigModel::orderBy('sort')->get();
	  
	  foreach ($config as $item) {
        if (!isset($data[$item->group_name])) {
		  $data[$item->group_name] = [];
        }
		$group[$item->group_name] = ['name'=>$item->group_name,'label'=>$item->group_label];
		
		$data[$item->group_name][] = $item;
	  }
	  
      return ["group"=>$group,"data"=>$data];
	}
	/*删除用户*/
	public function remove($id,$notify){}
}
