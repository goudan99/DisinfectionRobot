<?php
namespace App\Repositories;
use App\Model\Menu as MenuModel;
use App\Events\MenuStored;
use App\Events\MenuRemoved;
use App\Exceptions\AttachException;
use App\Exceptions\UniqueException;
use App\Exceptions\NotFoundException;
use App\Exceptions\AuthException;

class Menu implements Repository
{
	/***
	保存菜单
	***/
	public function store($data,$notify){
		
		if(isset($data['id'])&&$data['id']){
			
			if(!$menu=MenuModel::where("id",$data['id'])->first()){
				throw new NotFoundException("菜单不存在");
			}
			
			$menu->update($data);
			
			$notify["method"]="edit";
			
			event(new MenuStored($menu,$notify));
		
			return true ;
		}
			
		$menu=MenuModel::create($data);
			
		$notify["method"]="add";
		
		
		event(new MenuStored($menu,$notify));
		
		return true ;
	}
	
	/*删除菜单*/
	public function remove($data,$notify)
	{
		$menu=MenuModel::where("id",$data)->first();
		
		if(!$menu){return true;}
		
		if($menu->is_system==1)
		{
			throw new AuthException("系统菜单不允许删除");
		}
		
		$menu->delete();
		  
        $notify["method"]="remove";
		  
        event(new MenuRemoved($menu,$notify));
		
        return $menu;

	}
	
	/*菜单附加操作*/
	public function attach($data,$notify)
	{
		$menu=MenuModel::where('id',$data["id"])->first();
		
		if(!$menu){ throw new NotFoundException("菜单不存在");}
		
		if($menu->is_system==1){throw new AuthException("系统菜单不允许操作菜单权限");}
		
		$menu->access()->syncWithoutDetaching($data["access_id"]);
		
		$notify["method"]="attach";
		
        event(new MenuStored($menu,$notify));
		
        return true;
	}
	
	/*菜单移除操作*/
	public function detach($data,$notify)
	{
		$menu=MenuModel::where('id',$data["id"])->first();
		
		if(!$menu){throw new NotFoundException("菜单不存在");}
		
		if($menu->is_system==1){throw new AuthException("系统菜单不允许操作菜单权限");}
		
		$menu->access()->detach($data["access_id"]);
		
        $notify["method"]="detach";
		
        event(new MenuRemoved($menu,$notify));
		
        return true;
	}
}
