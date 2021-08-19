<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Config extends Model
{
	use Notifiable,HasFactory;
	
	protected $fillable = ['group','name','sort','field_type','key','value','default_value','option_value','is_private','help'];

}
