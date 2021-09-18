<?php
namespace App\Repositories;
use Illuminate\Support\Facades\Hash;
use App\Model\Job as JobModel;
use App\Events\JobStored;
use App\Events\JobRemoved;
use App\Exceptions\AttachException;
use App\Exceptions\UniqueException;
use App\Exceptions\NotFoundException;
use App\Exceptions\AuthException;
use App\Model\User;
use App\Model\Map;
use App\Model\Machine;
class Job implements Repository
{
	/*保存机器*/
	public function store($data,$notify){
		
		
        if($data["user_id"]){
			if($user=User::where('id',$data["user_id"])->first()){
				$data['user_name']=$user->phone;
			}
		}
		
        if($data["map_id"]){
			if($map=Map::where('id',$data["map_id"])->first()){$data['map_name']=$map->name;}
		}

        if($data["machine_id"]){
			if($machine=Machine::where('id',$data["machine_id"])->first()){$data['machine_name']=$machine->sn;}
		}

		if(isset($data['id'])&&$data['id']){
			
			if(!$job=JobModel::where("id",$data['id'])->first()){
				throw new NotFoundException("任务不存在");
			}
			$job->update($data);
			$notify["method"]="edit";
			event(new JobStored($job,$notify));
			return true ;
		}


		if(!$job=JobModel::create($data)){
			return false;
		}
			
		$notify["method"]="add";
		
		event(new JobStored($job,$notify));
		
		return true ;
	}
	
	/*删除用户*/
	public function remove($data,$notify)
	{
		$maps=JobModel::whereIn("id",$data)->get();
		
		JobModel::whereIn("id",$data)->delete();
		
		event(new JobRemoved($maps,$notify));
		  
		return $maps;
	}
}
