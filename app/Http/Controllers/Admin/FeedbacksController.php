<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Freedback;
use App\Http\Resources\FreedbackResource;
use App\Http\Resources\FreedbackCollection;
use App\Http\Requests\FreedbackRequest;
use App\Repositories\Freedback as objFreedback;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FeedbacksController extends Controller
{
    public function __construct(objFreedback $categoryRepositories)
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
		$limit=$request->limit?$request->limit:10;
		
		$limit=$limit>0?$limit:10;
		
		$freedbacks = Freedback::orderBy('id','desc');
		
		return $this->success(new FreedbackCollection($freedbacks->paginate($limit)));

    }

    /**
     * 保存反馈
     *
     * @return \Illuminate\Http\Response
     */
    public function store(FreedbackRequest $request)
    {
		$data=$request->all();
		
		$data["user_id"]=$this->user->id;
		
		$data["user_name"]=$this->user->phone;
		
		$this->getRepositories()->store($data,['form'=>['user'=>$this->user]]);
		 
		return $this->success("反馈成功");
    }

    /**
     * 删除反馈
     *
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
		$data = $request->all();
		
		$this->getRepositories()->remove($data,['form'=>['user'=>$this->user]]);
		
	    return $this->success([],"删除成功");
    }
	
    /**
     * 统计用户没有读的消息条数
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
		if (!$request->hasFile('file')) {
			return $this->error('请上传图像');;
        }
		
		$avatar=$this->getRepositories()->upload($request,['form'=>['user'=>$this->user]]);
		
		return $this->success($avatar,"操作成功");
    }
}
