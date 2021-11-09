<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Machine;
use App\Http\Resources\UserResource;
use App\Http\Resources\MachineCollection;
use App\Http\Requests\MachineRequest;
use App\Repositories\Machine as machineRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class MachineController extends Controller
{
    public function __construct(machineRepository $repository)
    {
        parent::__construct($repository);	
    }
    /**
     * 显示所有机器
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
		$limit=$request->limit?$request->limit:10;
				
		if($this->user->roles()->where("leve",1)->first()||$this->user->id==1){
			$machine = Machine::orderBy('id','desc');
		}else{
			$machine = $this->user->machines()->orderBy('id','desc');
		}

	    $request->get('key') ? $machine=$machine->where('name','like','%'.trim($request->get('key')).'%'):'';
		
		return $this->success(new MachineCollection($machine->paginate($limit)));
    }
	
	
    /**
     * 添加机器
     *
     * @return \Illuminate\Http\Response
     */
    public function store(MachineRequest $request)
    {
	   $this->getRepositories()->store($request->all(),['form'=>['user'=>$this->user]]);

	   return $this->success([],"操作成功");
    }
    /**
     * 显示后台用户详情
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
		$machine=Machine::where("id",$id)->first();
		$machine->users;
		return $this->success($machine,"获取成功");
	}
	
    /**
     * 删除后台用户
     *
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
		$data = $request->all();

	    $this->getRepositories()->remove($data,['form'=>['user'=>$this->user]]);
		
        return $this->success([],"删除成功");
    }
}
