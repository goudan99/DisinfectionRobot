<?php
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

/*保存或读取code*/
if (!function_exists('phonecode')) {
    /**
     * @return bool
     */
    function phonecode($phone,$type,$value=false)
    {
		$prefix="mobile_code";
		
		if($value===false){
			
          return request()->session()->get($prefix.$phone.$type);
		  
		}
		
		return request()->session()->put($prefix.$phone.$type,$value);
    }
}