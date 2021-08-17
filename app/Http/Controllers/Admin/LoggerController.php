<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\LoggerApi;
use App\Repositories\UnReposity;

class LoggerController extends Controller
{
    public function __construct(UnReposity $repo)
    {
        parent::__construct($repo);	
    }

    /**
     * 前端api接口错误请求保存.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		LoggerApi::create($request->all());
		
		return $this->success();
    }	
}
