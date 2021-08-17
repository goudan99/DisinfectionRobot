<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use App\Repositories\Profile;
use App\Model\Notice;

class ProfileController extends Controller
{
    public function __construct(Profile $profileRepositories,Request $request)
    {
		$profileRepositories->setUser($request->user('api'));
		
        parent::__construct($profileRepositories);	
    }
    /**
     * 显示个人信息
     *
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
		return $this->success($request->user('api'),"获取成功");
    }
    /**
     * 修改个人信息
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $this->getRepositories()->store($request->all(),['form'=>['user'=>$request->user]]);
		
        return $this->success($request->user('api'),"操作成功");
    }
    /**
     * 显示登录用户的信息
     *
     * @return \Illuminate\Http\Response
     */
    public function avatar(Request $request)
    {
		if (!$request->hasFile('file')) {
			return $this->error('头像不存在');;
        }
		
		$avatar=$this->getRepositories()->avatar($request,['form'=>['user'=>$request->user]]);
		
		return $this->success($avatar,"操作成功");
    }
    /**
     * 修改密码
     *
     * @return \Illuminate\Http\Response
     */
    public function password(Request $request)
    {
	
	    $this->getRepositories()->password($request->all(),['form'=>['user'=>$request->user]]);
		
		return $this->success('修改成功');
    }
    /**
     * 获取用户菜单
     *
     * @return \Illuminate\Http\Response
     */
    public function menu(Request $request)
    {
		return $this->success($request->user('api')->menus(),"获取成功");
    }
    /**
     * 获取用户通知
     *
     * @return \Illuminate\Http\Response
     */
    public function notice(Request $request)
    {
		return $this->success([
		  "unread"=>Notice::where("user_id",$request->user("api")->id)->where("is_read",0)->get(),
		  "readed"=>Notice::where("user_id",$request->user("api")->id)->where("is_read",1)->get(),
		  "trash"=>Notice::onlyTrashed()->where("user_id",$request->user("api")->id)->get()
		]);
    }
    /**
     * 设置通知已读
     *
     * @return \Illuminate\Http\Response
     */
    public function read(Request $request,$id)
    {
		$this->getRepositories()->read($id,['form'=>['user'=>$request->user]]);
		 
		return $this->success("操作成功");
    }
	
    /**
     * 删除通知
     *
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request,$id)
    {
		$this->getRepositories()->remove($id,['form'=>['user'=>$request->user]]);
		 
		return $this->success("删除成功");
    }
    /**
     * 恢复通知
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request,$id)
    {
		$this->getRepositories()->restore($id,['form'=>['user'=>$request->user]]);
		 
		return $this->success("操作成功");
    }
	
    /**
     * 显示通知详情
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
		return $this->success(Notice::where("id",$id)->first());
    }
}
