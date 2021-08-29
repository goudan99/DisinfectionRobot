<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Access extends Model
{
	use HasFactory;
	
	protected $fillable = ['parent_id', 'name','code','method','path'];
	
	public function roles()
    {
        return $this->belongsToMany('App\Model\Role');
    }
	public function menus()
    {
        return $this->belongsToMany('App\Model\Menu');
    }
}
