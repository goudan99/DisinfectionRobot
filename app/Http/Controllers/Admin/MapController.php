<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\Model\Map;
use App\Repositories\Map as MapReposity;
use App\Http\Resources\MapCollection;
use App\Http\Resources\MapResource;
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
		
		if(!($this->user->id==1||$this->user->roles()->where('level',1)->first())){
			$machines=[];
			
			foreach($this->user->machines()->get(["id"]) as $item){ array_push($machines,$item->id);}
			
			$map=$map->whereIn('machine_id',$machines);
		}
		
		$request->get('key') ? $map=$map->where('name','like','%'.trim($request->get('key')).'%'):'';
		
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
		
		if(!($this->user->id==1||$this->user->roles()->where('level',1)->first())){
			$machines=[];
			foreach($this->user->machines()->get(["id"]) as $item){ array_push($machines,$item->id);}
			$map=$map->whereIn('machine_id',$machines);
		}
		
		return $this->success(new MapResource($map->first()));
    }
	
    /**
     * 保存地图
     *
     * @return \Illuminate\Http\Response
     */
    public function store(MapRequest $request)
    {
	    if($this->user){$request->merge(["user_id"=>$this->user->id]);}
		
	    $this->getRepositories()->store($request->all(),['form'=>['user'=>$this->user]]);

	    return $this->success([],"保存成功");
	}
	
    /**
     * 删除地图
     *
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
	  $this->getRepositories()->remove($request->all(),['form'=>['user'=>$this->user]])

	   return $this->success([],"删除成功");
	}
}
