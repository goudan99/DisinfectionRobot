<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Scopes\CompanyScope;

class Map extends Model
{
	use HasFactory;

	protected $fillable = ['name','machine_id','machine_name','user_id','user_name','area','status'];
	
    protected $casts = [
        'area' => 'collection',
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
