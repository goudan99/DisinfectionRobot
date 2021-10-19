<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\LoggerApi;
use App\Model\LoggerUser;
use App\Model\LoggerJob;
use App\Repositories\LogReposity;
use Arcanedev\LogViewer\Contracts\LogViewer;
use Arcanedev\LogViewer\Tables\StatsTable;
use Arcanedev\LogViewer\Entities\{LogEntry, LogEntryCollection};
use Arcanedev\LogViewer\Exceptions\LogNotFoundException;
use Illuminate\Support\{Arr, Collection, Str};


class LoggerController extends Controller
{
    public function __construct(LogReposity $repo)
    {
        parent::__construct($repo);	
    }
	
    /**
     * 前端api接口错误请求保存.
     *
     * @return \Illuminate\Http\Response
     */
    public function api(Request $request)
    {
		return $this->success(LoggerApi::get());
    }
	
    /**
     * 前端api接口错误请求保存
     *
     * @return \Illuminate\Http\Response
     */
    public function job(Request $request)
    {
		
		$limit=$request->limit?$request->limit:10;
		
		$log = LoggerJob::orderBy('id','desc');
		
	    $request->get('key') ? $log=$log->where('job_name','like','%'.trim($request->get('key')).'%'):'';
		
	    $request->get('begin_at')&&$request->get('end_at') ? $log=$log->where(function($query)use ($request){
          $query->where('created_at','>' ,$request->get('begin_at'))->where('created_at', '<', $request->get('end_at'));
        }):'';
		
	    if($request->get('status')!=='-1'){
			$log=$log->where('status',$request->get('status'));
		}
		
		return $this->success($log->paginate($limit));
    }
	
    /**
     * 前端api接口错误请求保存.
     *
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
		$limit=$request->limit?$request->limit:10;
		
		$log = LoggerUser::orderBy('id','desc');
		
	    $request->get('key') ? $log=$log->where('job_name','like','%'.trim($request->get('key')).'%'):'';
		
	    $request->get('begin_at')&&$request->get('end_at') ? $log=$log->where(function($query)use ($request){
          $query->where('created_at','>' ,$request->get('begin_at'))->where('created_at', '<', $request->get('end_at'));
        }):'';
		
		
		return $this->success($log->paginate($limit));
    }
    /**
     * 前端api接口错误请求保存.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$this->getRepositories()->apiStore($request->all(),['form'=>['user'=>$this->user]]);
		
		return $this->success();
    }
    /**
     * 查看后端日志
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function code(Request $request)
    {
		$stats= app(LogViewer::class)->statsTable();
		
		$data=$stats->rows();
		
		$data = new Collection($data);
		
		$page = $request->get('page', 1);
		
		$limit = $request->get('limit', 30);
		
		return $this->success(["data"=>$data->forPage($page, $limit),"total"=>$data->count(),"page"=>$page]);
    }
	
    /**
     * 查看后端日志
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function codeShow(Request $request,$date)
    {
		$level   = $request->get('level', 'all');
		
		$page = $request->get('page', 1);
		
		$limit = $request->get('limit', 30);
		
        $query   = $request->get('query');
		
		$levels = [];
		
        $log = null;

        try {
            $log = app(LogViewer::class)->get($date);
        }catch (LogNotFoundException $e) {
            return $this->success(["data"=>[],"total"=>0,"page"=>1]);
        }
		foreach($log->tree() as $key=>$item){
		  $levels[$key]=["name"=>$item["name"],"count"=>$item["count"]];
		}
		
		$data = $log->entries($level);
		
		$data1=[];
		
		foreach($data->forPage($page, $limit) as $key=>$item){//第二页以后的数组他加了key导致json结构不一致，强制转化成一致
			$data1[]=$item;
		}
		
		return $this->success(["data"=>$data1,"leves"=>$levels,"total"=>$data->count(),"page"=>$page]);
    }

    /**
     * 删除后端日志
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function codeRemove(Request $request, $date)
    {
		$this->getRepositories()->codeRemove($date,['form'=>['user'=>$this->user]]);
		
		return $this->success();
    }
}
