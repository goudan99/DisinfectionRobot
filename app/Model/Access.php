<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Scopes\CompanyScope;

class Access extends Model
{
	use HasFactory;
	
	protected $fillable = ['parent_id', 'name','code','method','path'];
	
    /**
     * 模型的“启动”方法.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
    }
	
	public function roles()
    {
        return $this->belongsToMany('App\Model\Role');
    }
	public function menus()
    {
        return $this->belongsToMany('App\Model\Menu');
    }
}
