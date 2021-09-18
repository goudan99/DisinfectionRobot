<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\Model\Map;
use App\Repositories\Map as MapReposity;
use App\Http\Resources\MapCollection;
use App\Http\Resources\MapResource;
use App\Http\Resources\MapCollection;
use App\Http\Requests\MapRequest;

class MapController extends Controller
{
    public function __construct(MapReposity $repo)
    {
        parent::__construct($repo);	
    }
	
    /**
     * 显示所有地图
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
		$limit=$request->limit?$request->limit:10;
		
		$map=Map::orderby("id",'desc');
		
		return $this->success(new MapCollection($map->paginate($limit)));
    }
	
    /**
     * 地图详情
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
		$limit=$request->limit?$request->limit:10;
		
		$map=Map::where("id",$id);
		
		return $this->success(new MapResource($map->first()));
    }
	
    /**
     * 保存地图
     *
     * @return \Illuminate\Http\Response
     */
    public function store(MapRequest $request)
    {
	   if(!$this->getRepositories()->store($request->all(),['form'=>['user'=>$this->user]])){
			return $this->error('未知错误');
	   }

	   return $this->success([],"操作成功");
	}
	
    /**
     * 删除地图
     *
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
	   if(!$this->getRepositories()->remove($request->all(),['form'=>['user'=>$this->user]])){
			return $this->error('未知错误');
	   }

	   return $this->success([],"操作成功");
	}
}
