<?php
namespace App\Exceptions;
use App\Constant\Code;
use Exception;
/*
没有权限处理该资源
*/
class AuthException extends Exception
{
	protected  $msg;
	
	protected  $data;
	
	protected  $code;
	
    public function __construct($msg="",$data=[],$code=Code::AUTH)
    {
		$this->code=$code;
		$this->data=$data;
		$this->msg=$msg;
    }
	
	public function render($request){
		
		return response([
          'code' => $this->code,
          'msg' => $this->msg,
          'data' => $this->data,
          'timestamp' => time()
		]);
	}
}
