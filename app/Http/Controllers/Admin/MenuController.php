<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use App\Model\Menu;
use App\Repositories\Menu as objMenu;
use App\Http\Resources\GoodDetail;

class MenuController extends Controller
{
	
    public function __construct(objMenu $categoryRepositories)
    {
        parent::__construct($categoryRepositories);	
    }
    /**
     * 获取所有菜单
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
		return $this->success(Menu::get());
    }
    /**
     * 保存用户修改或添加的菜单
     *
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
		$data=$request->all();
		
		if(!$this->getRepositories()->store($data,['form'=>['user'=>$request->user()->user]])){
		   return $this->error('菜单不存在');
		}
		return $this->success([],'创建成功');
		
    }	
    /**
     * 删除菜单
     *
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
		if(!$num=$this->getRepositories()->remove($request->id,['form'=>['user'=>$request->user()->user]])){
		   return $this->error('删除失败,此菜单不存在或是系统菜单');
		}
		return $this->success([],'删除成功');
    }
    /**
     * 获取菜单所依赖的操作
     *
     * @return \Illuminate\Http\Response
     */
    public function Action(Request $request,$id)
    {
		return $this->success(Menu::where('id',$id)->first()->access);
    }
    /**
     * 删除菜单所依赖的操作
     *
     * @return \Illuminate\Http\Response
     */
    public function delAction(Request $request,$id)
    {
		$this->getRepositories()->detach(["id"=>$id,"access_id"=>$request->access_id],['form'=>['user'=>$request->user()->user]]);
		
		return $this->success([],'解除操作成功');
    }
    /**
     * 保存菜单所依赖的操作
     *
     * @return \Illuminate\Http\Response
     */
    public function storeAction(Request $request,$id)
    {
		$this->getRepositories()->attach(["id"=>$id,"access_id"=>$request->access_id],['form'=>['user'=>$request->user()->user]]);
		return $this->success([],'绑定操作成功');
		return $data;
    }
}
