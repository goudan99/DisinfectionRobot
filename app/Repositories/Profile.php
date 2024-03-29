<?php
namespace App\Repositories;
use Illuminate\Support\Facades\Hash;
use App\Events\UserStored;
use App\Events\UploadStored;
use App\Events\NoticeChanged;
use App\Model\User;
use App\Model\Notice;
use App\Model\Freedback;
use Storage;
use App\Exceptions\AttachException;
use App\Exceptions\UniqueException;
use App\Exceptions\NotFoundException;
use App\Exceptions\AuthException;
use App\Events\FreedbackSended;
use App\Events\NoticeSended;
use Illuminate\Validation\ValidationException;

class Profile implements Repository
{
	private $user;
	
    public function __construct(User $user)
    {
        $this->user=$user;
    }
	
	/*保存用户*/
	public function store($data,$notify){
		
	  isset($data["nickname"])?$this->user->nickname=$data["nickname"]:'';
		
	  isset($data["avatar"])?$this->user->avatar=$data["avatar"]:'';
		
      $this->user->save();

	  $notify["method"]="profile";

	  event(new UserStored($this->user,$notify));

	  return true ;
	}
	
	/*修改密码*/
	public function password($data,$notify){

	  //$data["password"]?$this->user->password=Hash::make($data["password"]):'';
	  
      $this->user->save();

	  $notify["method"]="password";

	  event(new UserStored($this->user,$notify));

	  return true ;
	}
	
	/*修改手机*/
	public function phone($data,$notify){

	  $data["phone"]?$this->user->phone=$data["phone"]:'';
	  
      $this->user->save();

	  $notify["method"]="phone";

	  event(new UserStored($this->user,$notify));

	  return true ;
	}
	
	/*上传头象*/
	public function avatar($request,$notify){

      if (!$request->hasFile('file')) {
		return false;
	  }
	  
	  $path=$request->file->store('avatar',config("robot")["avatar"]);
	  
	  //$url= url(Storage::disk(config("robot")["avatar"])->url($path));

	  $url= config("filesystems")["disks"][config("robot")["avatar"]]["url"]."/". $path;
	  
	  event(new UploadStored(["path"=>$path,"url"=>$url],$notify));

	  return $url;
	}
	
	/*删除已读通知*/
	public function remove($id,$notify)
	{
		if(!$notice=Notice::where("id",$id)->where("user_id",$this->user->id)->first()){return true;}
		
		$notify["method"]="remove";
		
		event(new NoticeChanged($notice,$notify));
		
		$notice->delete();
		
		return $notice;
	}
	
	/*发送通知消息*/
	public function send($data,$notify)
	{
		if($data["user_id"]){
			if(!User::where("id",$data["user_id"])->first()){
				throw ValidationException::withMessages(["user_id" => "用户不存在"]);
			}
		}
		$notice=Notice::create($data);
	
		$notify["method"]="add";
		
		event(new NoticeSended($notice,$notify));
		
		return $notice;
	}
	
	/*标志已读通知*/
	public function read($id,$notify)
	{
		if(!$notice=Notice::where("id",$id)->where("user_id",$this->user->id)->first()){
			throw new NotFoundException("通知不存在");
		}
		
		$notice->is_read=1;
		
		$notice->save();
		
		$notify["method"]="read";
		
		event(new NoticeChanged($notice,$notify));
		
		return $notice;
	}
	
	/*标志已读通知*/
	public function top($id,$notify)
	{
		if(!$notice=Notice::where("id",$id)->where("user_id",$this->user->id)->first()){
			throw new NotFoundException("通知不存在");
		}
		
		$notice->is_top=1;
		
		$notice->save();
		
		$notify["method"]="read";
		
		event(new NoticeChanged($notice,$notify));
		
		return $notice;
	}
	
	/*恢复删除*/
	public function restore($id,$notify)
	{
		if(!$notice=Notice::withTrashed()->where("id",$id)->where("user_id",$this->user->id)->first()){
			throw new NotFoundException("通知不存在");
		}
		
		$notify["method"]="restore";
		
		event(new NoticeChanged($notice,$notify));
		
		return Notice::where("id",$id)->where("user_id",$this->user->id)->restore();
	}
	/*设置当前用户*/
	public function setUser($user)
	{
		$this->user=$user;
	}
	
	/*上传反馈图片*/
	public function upload($request,$notify)
	{

      if (!$request->hasFile('file')) {return false;}
	  
	  $path=$request->file->store('freeback',config("robot")["freedback"]);
	  
	  //$url= url(Storage::disk(config("robot")["freedback"])->url($path));

	  $url= config("filesystems")["disks"][config("robot")["freedback"]]["url"]."/". $path;
	  
	  event(new UploadStored(["path"=>$path,"url"=>$url],$notify));

	  return $url;
	}
	
	/*用户反馈*/
	public function feedback($data,$notify)
	{
		$notice=Freedback::create($data);
	
		$notify["method"]="add";
		
		event(new FreedbackSended($notice,$notify));
		
		return $notice;
	}
}
