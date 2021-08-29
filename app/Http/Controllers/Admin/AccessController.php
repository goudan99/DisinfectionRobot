<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Access;
use Illuminate\Routing\Router;
use App\Repositories\Access as AccessReposity;
use App\Http\Requests\AccessRequest;

class AccessController extends Controller
{
    public function __construct(AccessReposity $repo)
    {
        parent::__construct($repo);	
    }
	
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
		return $this->success(Access::get());
    }
	
    public function uri(Request $request)
    {
        $routes = collect(app('router')->getRoutes())->map(function ($route) {
			if(in_array("permit:api",$route->gatherMiddleware())){
				return [
					'host'   => $route->domain(),
					'method' => implode('|', $route->methods()),
					'path'    => $route->uri(),
					'code'   => $route->getName(),
					'action' => ltrim($route->getActionName(), '\\'),
					'middleware' => $route->gatherMiddleware(),
				];
			}
        })->whereNotNull()->values()->all();

		return $this->success($this->getRepositories()->uri($routes));
    }
    public function store(AccessRequest $request)
    {
		return $this->success($this->getRepositories()->store($request->all(),['form'=>['user'=>$request->user]]));
	}
	
    public function remove(Request $request,$id)
    {
		return $this->success($this->getRepositories()->remove($id,['form'=>['user'=>$request->user]]));
	}
}
