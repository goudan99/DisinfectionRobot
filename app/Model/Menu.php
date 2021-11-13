<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Scopes\CompanyScope;

class Menu extends Model
{
	use HasFactory;
	
	protected $fillable = ['parent_id', 'name','desc','prefix','path','icon','target','order','status','is_system'];
   
    /**
     * 模型的“启动”方法.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
    }
	
    public function access()
    {
        return $this->belongsToMany('App\Model\Access');
    }	
}
