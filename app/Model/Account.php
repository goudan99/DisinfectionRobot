<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Account extends Authenticatable  implements JWTSubject
{
	use Notifiable,HasFactory;
	  
	protected $fillable = ['user_id','name','password','passed','type'];
	
	public function user()
    {
         return $this->belongsTo('App\Model\User');
    }
	
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
	
    public function getJWTCustomClaims()
    {
        return [''];
    }
	
}
