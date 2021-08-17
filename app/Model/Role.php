<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
	use HasFactory;
	
	protected $fillable = ['name','status','desc'];
	
    public function access()
    {
        return $this->belongsToMany('App\Model\Access');
    }
	
    public function users()
    {
        return $this->hasMany('App\Model\User');
    }
	
    public function menus()
    {
		$arr=$this->access->map(function($items, $key){return $items->menus->toArray();})->collapse()->unique('id');
		$menu=Menu::where('prefix','http://')->orWhere('prefix','https://')->get();
		$arr=$menu->concat($arr->toArray());
		$menu=Menu::where('id',0);
		foreach(explode(',',$arr->unique('parent_id')->implode('parent_id',',')) as $item){
			$menu->orWhere('id',$item);
		}
		$arr=$menu->get()->concat($arr->toArray());
		return $arr;
    }
}
