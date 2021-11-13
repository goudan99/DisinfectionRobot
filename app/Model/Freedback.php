<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\CompanyScope;

class Freedback extends Model
{
	use Notifiable,HasFactory;
	  
	protected $fillable = ['user_id','user_name','phone','desc','pics','status'];
	
    protected $casts = [
        'pics' => 'collection',
    ];
	
    /**
     * 模型的“启动”方法.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
    }

}
