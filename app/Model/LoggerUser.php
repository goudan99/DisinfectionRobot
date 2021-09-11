<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoggerUser extends Model
{
	use HasFactory;
	
    protected $table = 'logger_user';
	
	protected $fillable = ['code','msg','type','url'];
}
