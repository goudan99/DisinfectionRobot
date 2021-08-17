<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Notice;
use App\Repositories\UnReposity;

class AnalysisController extends Controller
{
    public function __construct(UnReposity $repo)
    {
        parent::__construct($repo);	
    }
    /**
     * 统计用户没有读的消息条数
     *
     * @return \Illuminate\Http\Response
     */
    public function unread(Request $request)
    {
		return $this->success(Notice::where("user_id",$request->user("api")->id)->where("is_read",0)->count());
    }	
}
