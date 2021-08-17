<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Http\Requests\UserRequest;
use App\Repositories\User as objUser;

class UserController extends Controller
{
    public function __construct(objUser $categoryRepositories)
    {
        parent::__construct($categoryRepositories);	
    }
    /**
     * 显示所有后台用户
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
		$limit=$request->limit?$request->limit:10;
		
		return $this->success(new UserCollection(User::paginate($limit)));
    }

    /**
     * 添加后台用户
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
	   if(!$this->getRepositories()->store($request->all(),['form'=>['user'=>$request->user]])){
			return $this->error('用户存在');
	   }

	   return $this->success([],"操作成功");
    }
    /**
     * 显示后台用户详情
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
		return $this->success(new UserResource(User::where("id",$id)->first()),"获取成功");
	}
	
    /**
     * 删除后台用户
     *
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
		if($request->user('api')->id==$request->id){
			return $this->error('删除失败,你不能删除自己');
		}
	    if($this->getRepositories()->remove($request->id,['form'=>['user'=>$request->user]])){
          return $this->success([],"删除成功");
		}else{
          return $this->error('删除失败,该用户不存在或是系统用户');
		}
    }
}
