<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\Model\Job;
use App\Repositories\Job as JobReposity;
use App\Http\Resources\JobCollection;
use App\Http\Resources\JobResource;
use App\Http\Requests\JobRequest;

class JobController extends Controller
{
    public function __construct(JobReposity $repo)
    {
        parent::__construct($repo);	
    }
	
    /**
     * 显示所有任务
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
		$limit=$request->limit?$request->limit:10;

		$job=Job::orderby("id",'desc');
		
		$machines=[];
		
		foreach($this->user->machines()->get(["id"]) as $item)
		{
		  array_push($machines,$item->id);	
		}
		
		if($this->user->id!=1){
			$job=$job->whereIn('machine_id',$machines);
		}
		$request->get('status') ? $job=$job->where('status',trim($request->get('status'))):'';
		
		$request->get('machine_id') ? $job=$job->where('machine_id',trim($request->get('machine_id'))):'';
		
		$request->get('type_id') ? $job=$job->where('type_id',trim($request->get('type_id'))):'';
		
		$request->get('start_at') ? $job=$job->where('start_at',trim($request->get('start_at'))):'';
		
		$job=$job->paginate($limit);
		
		return $this->success(new JobCollection($job));
    }
	
    /**
     * 任务详情
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
		$limit=$request->limit?$request->limit:10;
		
		$job=Job::where("id",$id)->first();
		
		return $this->success(new JobResource($job));
    }
	
    /**
     * 保存任务
     *
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequest $request)
    {
	  if($this->user){
		$request->merge([
		  "user_id"=>$this->user->id,
		  "user_name"=>$this->user->phone
		]);
	  }

	   $this->getRepositories()->store($request->all(),['form'=>['user'=>$this->user]]);

	   return $this->success([],"操作成功");
	}
	
    /**
     * 删除任务
     *
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
	   if(!$this->getRepositories()->remove($request->all(),['form'=>['user'=>$this->user]])){
			return $this->error('未知错误');
	   }

	   return $this->success([],"操作成功");
	}
}
