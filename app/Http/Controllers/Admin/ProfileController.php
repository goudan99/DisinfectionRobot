<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use App\Repositories\Profile;
use App\Model\Notice;
use App\Constant\Code;
use App\Repositories\Mobile;
use App\Http\Requests\RestPasswordRequest;
use App\Http\Requests\RestPhoneRequest;

class ProfileController extends Controller
{
    public function __construct(Profile $profileRepositories,Request $request)
    {
        parent::__construct($profileRepositories);
		
		$profileRepositories->setUser($this->user);	
    }
    /**
     * 显示个人信息
     *
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
		return $this->success($this->user,"获取成功");
    }
    /**
     * 修改个人信息
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $this->getRepositories()->store($request->all(),['form'=>['user'=>$this->user]]);
		
        return $this->success($this->user,"操作成功");
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
		
		$avatar=$this->getRepositories()->avatar($request,['form'=>['user'=>$this->user]]);
		
		return $this->success($avatar,"操作成功");
    }
    /**
     * 修改密码
     *
     * @return \Illuminate\Http\Response
     */
    public function password(RestPasswordRequest $request)
    {
		$data=$request->all();
		
		if($data["code"]!=phonecode($this->user->phone,Mobile::CHANGE)){
            throw ValidationException::withMessages([
              "code" => "验证码不正确",
            ]);
		}
		
	    $this->getRepositories()->password($data,['form'=>['user'=>$this->user]]);
		
		$request->session()->put('mobile_code_'.Mobile::CHANGE,'');//修改完以后清掉这个session值
		
		return $this->success('修改成功');
    }
	
    /**
     * 修改手机
     *
     * @return \Illuminate\Http\Response
     */
    public function phone(RestPhoneRequest $request)
    {

		$data=$request->all();

		if($data["oldcode"]!=$request->session()->get('mobile_code_'.Mobile::CHANGEPHONE)){
			
			return $this->error('验证码不正确'.$request->session()->get('mobile_code_'.Mobile::CHANGEPHONE),[], Code::VALIDATE);
		}
		
		if($data["code"]!=$request->session()->get('mobile_code_'.$data["phone"].'_'.Mobile::VALIDATEPHONE)){
			
			return $this->error('新手机验证码不正确',[], Code::VALIDATE);
		}
		
	    $this->getRepositories()->phone($data,['form'=>['user'=>$this->user]]);
		
		$request->session()->put('mobile_code_'.Mobile::CHANGEPHONE,'');//修改完以后清掉这个session值
		
		$request->session()->put('mobile_code_'.$data["phone"].'_'.Mobile::VALIDATEPHONE,'');//修改完以后清掉这个session值
		
		return $this->success('修改成功');
    }
	
    /**
     * 获取用户菜单
     *
     * @return \Illuminate\Http\Response
     */
    public function menu(Request $request)
    {
		return $this->success($this->user->menus(),"获取成功");
    }
    /**
     * 获取用户通知
     *
     * @return \Illuminate\Http\Response
     */
    public function notice(Request $request)
    {
		return $this->success(Notice::withTrashed()->where("user_id",$this->user->id)->orderBy('id','desc')->get());
    }
    /**
     * 设置通知已读
     *
     * @return \Illuminate\Http\Response
     */
    public function read(Request $request,$id)
    {
		$this->getRepositories()->read($id,['form'=>['user'=>$this->user]]);
		 
		return $this->success("操作成功");
    }
	
    /**
     * 设置通知已读
     *
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
		$data=$request->all();
		
		$data["user_id"]=$this->user->id;
		
		$this->getRepositories()->send($data,['form'=>['user'=>$this->user]]);
		 
		return $this->success("操作成功");
    }
	
    /**
     * 删除通知
     *
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request,$id)
    {
		$this->getRepositories()->remove($id,['form'=>['user'=>$this->user]]);
		 
		return $this->success("删除成功");
    }
    /**
     * 恢复通知
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request,$id)
    {
		$this->getRepositories()->restore($id,['form'=>['user'=>$this->user]]);
		 
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
	
    /**
     * 统计用户没有读的消息条数
     *
     * @return \Illuminate\Http\Response
     */
    public function unread(Request $request)
    {
		return $this->success(Notice::where("user_id",$this->user->id)->where("is_read",0)->count());
    }
}
