<?php
namespace App\Exceptions;
use App\Constant\Code;
use Exception;

/*
资源冲突
*/
class UniqueException extends Exception
{
	protected  $msg;
	
	protected  $data;
	
	protected  $code;
	
    public function __construct($msg="",$data=[],$code=Code::UNIQUE)
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
