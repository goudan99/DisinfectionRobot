<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Config;
use App\Repositories\Config as repo;

class SettingController extends Controller
{
    public function __construct(repo $repo)
    {
        parent::__construct($repo);	
    }
	
    /**
     * 显示配置
     *
     * @return \Illuminate\Http\Response
     */
    public function config(Request $request)
    {
		return $this->success($this->getRepositories()->show(),"获取成功");
	}
    /**
     * 保存配置文件中的图片
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
		$avatar=$this->getRepositories()->upload($request,['form'=>['user'=>$request->user()->user]]);
		
		return $this->success($avatar,"操作成功");
    }
	
    /**
     * 保存配置文件
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	   $this->getRepositories()->store($request->all(),['form'=>['user'=>$request->user()->user]]);

	   return $this->success([],"保存完成");
    }

}
