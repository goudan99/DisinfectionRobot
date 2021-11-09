<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Http\Requests\UserRequest;
use App\Repositories\Upload;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function __construct(Upload $categoryRepositories)
    {
        parent::__construct($categoryRepositories);	
    }
    /**
     * 所有图库
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
		return $this->success($this->user->uploads()->orderby("id",'desc')->get());
    }

    /**
     * 分享图片
     *
     * @return \Illuminate\Http\Response
     */
    public function share(Request $request)
    {
	  $this->getRepositories()->share($request->all(),['form'=>['user'=>$this->user]]);
	  
	  return $this->success([],"操作成功");
    }

    /**
     * 删除图片
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
