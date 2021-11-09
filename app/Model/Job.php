<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
	use HasFactory;

	protected $fillable = ['name','machine_id','machine_name','user_id','user_name','map_id','map_name','map_area','rate_type','work','is_clean','is_test','start_at','end_at','status','type_id'];
	
    protected $casts = [
        'map_area' => 'collection',
        'work' => 'collection'
    ];
	
    public function machine()
    {
        return $this->belongsTo('App\Model\Machine');
    }

    public function map()
    {
        return $this->belongsTo('App\Model\Map');
    }
	
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
}
