<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\CompanyScope;

class Upload extends Model
{
	use Notifiable,HasFactory;
	  
	protected $fillable = ['user_id','user_name','url','from_type','from_id','remark','company_id'];

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
	
    public function machine()
    {
        return $this->belongsTo('App\Model\Machine');
    }
	
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

}
