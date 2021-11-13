<?php
use TencentCloud\Sms\V20210111\SmsClient;
use TencentCloud\Sms\V20210111\Models\SendSmsRequest;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use Illuminate\Support\Facades\Cache;
use EasyWeChat\Factory;
use App\Constant\Code;
use App\Exceptions\AttachException;
use App\Model\Invite;

if (!function_exists('platform')) {
    /**
     * @return bool
     */
    function platform()
    {
        if (strpos(request()->server('HTTP_USER_AGENT'), 'miniprogram')) {
            return 'miniprogram';
        }
        return false;
    }
}
/*检查邀请码*/
if (!function_exists('checkInvite')) {
    /**
     * @return bool
     */
    function checkInvite($code,$company_id=0)
    {
		if(!$company_id){
			return Invite::where('code',$code)->where('status','<>',1)->first();
		}
		return Invite::where('code',$code)->where('company_id',$company_id)->where('status','<>',1)->first();
    }
}

/*保存或读取code*/
if (!function_exists('phonecode')) {
    /**
     * @return bool
     */
    function phonecode($phone,$type,$value=false)
    {
		$prefix="mobile_code";
		
		$key=$prefix.$phone.$type;

		if($value===false){ return Cache::get($key);}
		
		return Cache::put($key,$value);
    }
}

/*保存或读取code*/
if (!function_exists('openid')) {
    /**
     * @return bool
     */
    function openid($code)
    {
		if(config("app")["env"]=="local"||config("app")["env"]=="testing"){return "test_openid";}
		
		$config = config("robot")["miniProgram"];
		
		$app = Factory::miniProgram($config);
		
		$wedata = $app->auth->session($code);
		
		if(isset($wedata["errcode"])){throw new AttachException("wechat_code无效，重新获取",[],Code::VALIDATE);}
		
		$openid = $wedata["openid"];
		
		return $openid;
		
    }
}

/*保存或读取code*/
if (!function_exists('sendSms')) {
    /**
     * @return bool
     */
    function sendSms($phone,$tempid,$code)
    {
		//try {
			$cred = new Credential(config("robot")["sms"]["secret"],config("robot")["sms"]["key"]);
			$httpProfile = new HttpProfile();
			$httpProfile->setReqMethod("GET");  // post请求(默认为post请求)
			$httpProfile->setReqTimeout(30);    // 请求超时时间，单位为秒(默认60秒)
			$httpProfile->setEndpoint("sms.tencentcloudapi.com");  // 指定接入地域域名(默认就近接入)

			//区域为广州区域
			$clientProfile = new ClientProfile();
			$clientProfile->setSignMethod("TC3-HMAC-SHA256");
			$clientProfile->setHttpProfile($httpProfile);
			$client = new SmsClient($cred, "ap-guangzhou", $clientProfile);
			
			$req = new SendSmsRequest();
			$req->SmsSdkAppId = config("robot")["sms"]["appid"];
			$req->SignName = config("robot")["sms"]["signName"];
			$req->PhoneNumberSet = array($phone);
			$req->TemplateId = $tempid;
			$req->TemplateParamSet = array($code);
			$resp = $client->SendSms($req);
			// 输出json格式的字符串回包
			//print_r($resp->toJsonString());
			// 也可以取出单个值。
			// 您可以通过官网接口文档或跳转到response对象的定义处查看返回字段的定义
			//print_r($resp->TotalCount);
		//}
		//catch(TencentCloudSDKException $e) {  //交给总处理处理错误
		//	echo $e;
		//}
    }
}