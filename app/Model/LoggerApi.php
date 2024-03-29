<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoggerApi extends Model
{
	use HasFactory;
	
    protected $table = 'logger_api';
	
	protected $fillable = ['code','msg','type','url'];
}
