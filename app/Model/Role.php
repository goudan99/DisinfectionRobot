<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Scopes\CompanyScope;

class Role extends Model
{
	use HasFactory;
	
	protected $fillable = ['name','status','desc'];
	
    /**
     * 模型的“启动”方法.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
    }
	
    public function access()
    {
        return $this->belongsToMany('App\Model\Access');
    }
	
    public function users()
    {
        return $this->belongsToMany('App\Model\User');
    }
	
    public function menus()
    {
		//获取菜单不需要权限控制的菜单
		$menu=Menu::has('access', '=', 0)->get();
		
		//与有权限菜单合并
		$arr=$menu->concat(
			//取得对权限对应的菜单
			$this->access->map(function($items, $key){
				return $items->menus->toArray();
			})->collapse()->unique('id')->toArray()
		);
		//获取可用菜单父类菜单
		$menu=Menu::where('id',0);
		foreach(explode(',',$arr->unique('parent_id')->implode('parent_id',',')) as $item){
			$menu->orWhere('id',$item);
		}
		if($menu->get()){
		  $arr=$menu->get()->concat($arr->toArray());
		}

		return $arr;
    }
}
