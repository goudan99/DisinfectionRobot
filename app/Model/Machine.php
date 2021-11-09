<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Machine extends Model
{
	use HasFactory;
	
	protected $fillable = ['sn','name','status','move_speed','power_setting'];
	
    public function users()
    {
        return $this->belongsToMany('App\Model\User');
    }
}
