<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freedback extends Model
{
	use Notifiable,HasFactory;
	  
	protected $fillable = ['user_id','user_name','phone','desc','pics','status'];
	
    protected $casts = [
        'pics' => 'collection',
    ];

}
