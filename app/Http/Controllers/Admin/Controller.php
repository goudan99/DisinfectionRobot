<?php

namespace App\Http\Controllers\Admin;
use App\Repositories\Repository;
use App\Constant\Code;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
	protected $repository;
	
	protected $user;
	
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
		
		$this->user = Auth::user("api")?Auth::user("api")->user:null;
    }
	protected function getRepositories(){
		
		return $this->repository;
	}
	
    protected function success($data=[],$msg = '')
    {
        return [
          'code' => Code::SUCCESS,
          'msg' => $msg,
          'data' => $data,
          'timestamp' => time()
        ];
    }
	
    protected function error($msg = '',$data=[],$code=Code::FAIL)
    {
        return [
          'code' => $code,
          'msg' => $msg,
          'data' => $data,
          'timestamp' => time()
        ];
    }
}
