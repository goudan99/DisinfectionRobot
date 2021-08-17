<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Role;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Http\Resources\RoleCollection;
use App\Repositories\Role as objRole;


class RoleController extends Controller
{

    public function __construct(objRole $categoryRepositories)
    {
        parent::__construct($categoryRepositories);	
    }
	
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
		$limit=$request->limit?$request->limit:10;
		
		return $this->success(new RoleCollection(Role::paginate($limit)));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
	   if(!$this->getRepositories()->store($request->all(),['form'=>['user'=>$request->user]])){
		   return $this->error('处理失败');
	   }

	   return $this->success([],'操作成功');
    }

    public function show(Request $request,$id)
    {
		
		return $this->success(new RoleResource(Role::where("id",$request->id)->first()));
	}
	
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
	   if(!$this->getRepositories()->remove($request->id,['form'=>['user'=>$request->user]])){
		   return ['code'=>101,'timestamp'=>time(),"data"=>[],'msg'=>'处理失败'];
	   }
	   
	   return ['code'=>0,'timestamp'=>time(),"data"=>1,'msg'=>'删除成功'];
    }
}
