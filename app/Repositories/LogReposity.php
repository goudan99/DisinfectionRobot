<?php
namespace App\Repositories;
use App\Events\LogRemoved;
use App\Events\LogStored;
use App\Model\LoggerApi;

class LogReposity implements Repository
{
	public function store($data,$notify){}
	public function remove($id,$notify)	{}
	
	public function apiStore($data,$notify){
		
		$log=LoggerApi::create($data);
		
		$notify["method"]="add";
		
		event(new LogStored($log,$notify));
	}
	
	public function codeRemove($date,$notify)	{
		
		if(app(LogViewer::class)->delete($date)){
			
			$notify["type"]="code";

			event(new LogRemoved($date,$notify));
		}
		
		return true;
	}
}
