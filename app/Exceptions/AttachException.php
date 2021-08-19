<?php
namespace App\Exceptions;
use App\Constant\Code;
use Exception;

/*
依赖资源不存在
*/
class AttachException extends Exception
{
	protected  $msg;
	
	protected  $data;
	
	protected  $code;
	
    public function __construct($msg="",$data=[],$code=Code::ATTACH)
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
