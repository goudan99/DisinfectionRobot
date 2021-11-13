<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Scopes\CompanyScope;

class Machine extends Model
{
	use HasFactory;
	
	protected $fillable = ['sn','name','status','move_speed','power_setting'];
	
    /**
     * 模型的“启动”方法.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
    }
	
    public function users()
    {
        return $this->belongsToMany('App\Model\User');
    }
	
	public function uploads()
    {
         return $this->hasMany('App\Model\Upload');
    }
}
