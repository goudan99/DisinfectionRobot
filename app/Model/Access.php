<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Access extends Model
{
	use HasFactory;
	
	protected $fillable = ['parent_id', 'name','desc','prefix','path','icon','target','order','status','is_system'];
	
    public function menus()
    {
        return $this->belongsToMany('App\Model\Menu');
    }	
}
