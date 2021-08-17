<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Access;
use Illuminate\Routing\Router;
use App\Repositories\UnReposity;

class AccessController extends Controller
{
    public function __construct(UnReposity $repo)
    {
        parent::__construct($repo);	
    }
	
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
		return $this->success(Access::get());
    }
}
