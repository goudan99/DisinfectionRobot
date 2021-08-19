<?php
namespace App\Exceptions;
use App\Constant\Code;
use Exception;
/*
资源不存在
*/
class NotFoundException extends Exception
{
	protected  $msg;
	
	protected  $data;
	
	protected  $code;
	
    public function __construct($msg="",$data=[],$code=Code::NOTFOUND)
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
