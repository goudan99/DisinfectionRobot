<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\CompanyScope;

class Notice extends Model
{
	use HasFactory,SoftDeletes;
	
    protected $table = 'notice';
	
	protected $fillable = ['title','content','user_id','form_id','is_top','company_id'];
	
    /**
     * 模型的“启动”方法.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
    }
}
