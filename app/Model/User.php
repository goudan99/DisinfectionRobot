<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	use Notifiable,HasFactory;
	  
	protected $fillable = ['nickname','avatar','phone','code','desc','passed','openid','is_first','company_id'];
	
	public function accounts()
    {
         return $this->hasMany('App\Model\Account');
    }
	
	public function roles()
    {
         return $this->belongsToMany('App\Model\Role');
    }
	
	public function machines()
    {
         return $this->belongsToMany('App\Model\Machine')->withPivot(['machine_name']);
    }
	
	public function uploads()
    {
         return $this->hasMany('App\Model\Upload');
    }
	
	public function menus()
    {
		if($this->id==1){
			return Menu::get();		
		}elseif($this->role){
			return $this->role->menus();	
		}else{
			return ;
		}      
    }
	
	public function access()
    {
		$arr=[];
		
		if($this->id==1){
			return Access::get();		
		}elseif($this->roles){
			foreach($this->roles as $item){
				$arr=array_merge($arr,$item->access->toArray());
			}
			return $arr;	
		}else{
			return $arr;
		}       
    }
	
	public function check($path,$method)
    {
	  if($this->id==1){
		return true; 
	  }
	  if(!$this->roles){
		 return false;
	  }
	  
	foreach($this->roles as $item){
	  if($item->access->where('path',$path)->where('method',implode('|',$method))->toArray()){
		 return true;
	  }
	}
			

      return false; 
    }
	
}
