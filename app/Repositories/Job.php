<?php
namespace App\Repositories;
use Illuminate\Support\Facades\Hash;
use App\Model\Job as JobModel;
use App\Events\JobStored;
use App\Events\JobRemoved;
use App\Events\JobChanaged;
use App\Exceptions\AttachException;
use App\Exceptions\UniqueException;
use App\Exceptions\NotFoundException;
use App\Exceptions\AuthException;
use App\Model\User;
use App\Model\Map;
use App\Model\Machine;
use Illuminate\Validation\ValidationException;

class Job implements Repository
{
	/*保存机器*/
	public function store($data,$notify){
		
		if(!isset($data["status"])){$data["status"]=2;}
		
		if(!isset($data["type_id"])){$data["type_id"]=1;}
		
        if($data["user_id"]){
			if($user=User::where('id',$data["user_id"])->first()){
				$data['user_name']=$user->phone;
			}
		}
		
        if($data["map_id"]){
			if($map=Map::where('id',$data["map_id"])->first()){$data['map_name']=$map->name;}
		}
		
        if(isset($data["start_at"])){
			
			$start=$data['start_at'];
			
			$start1=date('Y-m-d H:i:s',strtotime("-2 hours",strtotime($data['start_at'])));
			
			$start2=date('Y-m-d H:i:s',strtotime("+2 hours",strtotime($data['start_at'])));

			if(JobModel::where("start_at",'>',$start1)->where("start_at",'<',$start2)->where("machine_id",$data["machine_id"])->where("status",2)->first()){
				throw ValidationException::withMessages(["start_at" => "在该时间段内有其人任务在执行"]);
			}
		}

        if($data["machine_id"]){
			
			if($machine=Machine::where('id',$data["machine_id"])->first()){$data['machine_name']=$machine->sn;}

			if(!($user->id==1||$user->roles()->where('level',1)->first())){
				if(!$notify["form"]["user"]->machines()->where("id",$data["machine_id"])->first()){
					throw ValidationException::withMessages(["machine_id" => "该机器不存在，或者你没有权限操控此机器"]);
				}
			}

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

		$jobs=JobModel::whereIn("id",$data);
		
		$user=$notify["form"]["user"];
		
		if(!($user->id==1||$user->roles()->where('level',1)->first())){
			
			$machines=[];
			
			foreach($user->machines()->get(["id"]) as $item){ array_push($machines,$item->id);}
			
			$jobs=$jobs->whereIn('machine_id',$machines);
		}

		if(!$jobs->get()->toArray()){throw ValidationException::withMessages(["machine_id" => "该任务不存在，或者你没有权限操控此任务"]);}
		
		JobModel::whereIn("id",$data)->delete();
		
		event(new JobRemoved($jobs,$notify));
		  
		return $jobs;
	}
	
	/*改变任务状态*/
	public function change($data,$notify)
	{
		$jobs=JobModel::whereIn("id",$data["id"]);

		$user=$notify["form"]["user"];
		
		if(!($user->id==1||$user->roles()->where('level',1)->first())){
			
			$machines=[];
			
			foreach($user->machines()->get(["id"]) as $item){ array_push($machines,$item->id);}
			
			$jobs=$jobs->whereIn('machine_id',$machines);
		}

		if(!$jobs->get()->toArray()){throw ValidationException::withMessages(["machine_id" => "该任务不存在，或者你没有权限操控此任务"]);}

		JobModel::whereIn("id",$data)->update(['status'=>$data["status"]]);
		
		event(new JobChanaged($jobs,$notify));
		  
		return $jobs;
	}	
}
