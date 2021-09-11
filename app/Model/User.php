<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable
{
	use Notifiable,HasApiTokens,HasFactory;
	  
	protected $fillable = ['name','password','nickname','avatar','phone','email','desc','passed'];
	
    protected $hidden = ['password', 'remember_token'];
	 
    public function findForPassport($login)
    {
        return $this->orWhere('name', $login)->first();
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
	  if($this->role->access->where('path',$path)->where('method',implode('|',$method))->first()){
		return true;   
	  }
      return false; 
    }
	
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
	
    public function getJWTCustomClaims()
    {
        return [];
    }
}
