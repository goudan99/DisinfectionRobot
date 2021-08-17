<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
	use HasFactory,SoftDeletes;
	
    protected $table = 'notice';
	
	//protected $fillable = [];
}
