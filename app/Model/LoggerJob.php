<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoggerJob extends Model
{
	use HasFactory;
	
    protected $table = 'logger_job';
	
	protected $fillable = ['code','msg','type','url'];
}
