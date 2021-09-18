<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
	use HasFactory;

	protected $fillable = ['name','machine_id','area','status'];
	
    protected $casts = [
        'area' => 'collection',
    ];
}
