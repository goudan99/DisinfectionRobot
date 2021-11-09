<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
	use Notifiable,HasFactory;
	  
	protected $fillable = ['user_id','user_name','url','from_type','from_id','remark'];
	
    public function machine()
    {
        return $this->belongsTo('App\Model\Machine');
    }
	
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

}
