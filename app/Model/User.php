<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	use Notifiable,HasFactory;
	  
	protected $fillable = ['nickname','avatar','phone','code','desc','passed','openid'];
	
	public function accounts()
    {
         return $this->hasMany('App\Model\Account');
    }
	
	public function roles()
    {
         return $this->belongsToMany('App\Model\Role');
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
	
	public function check($path,$method)
    {
	  if($this->id==1){
		return true; 
	  }
	  if(!$this->role){
		 return false;
	  }
	  if($this->role->access->where('path',$path)->where('method',implode('|',$method))->first()){
		return true;   
	  }
      return false; 
    }
	
}
