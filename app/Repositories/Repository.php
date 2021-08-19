<?php
namespace App\Repositories;

interface Repository
{
	public function store($data,$notify);
	
	public function remove($data,$notify);

}
