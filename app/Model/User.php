<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
	use Notifiable,HasApiTokens,HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */	 

	
	//protected $keyType = 'string';
	  
	protected $fillable = ['name','password','nickname','role_id','role_name','avatar','phone','email','desc','passed'];
	
    protected $hidden = ['password', 'remember_token'];
	 
    public function findForPassport($login)
    {
        return $this->orWhere('name', $login)->first();
    }
	
	public function role()
    {
         return $this->belongsTo('App\Model\Role');
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
}
