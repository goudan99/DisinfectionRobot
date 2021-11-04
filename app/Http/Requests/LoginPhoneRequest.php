<?php

namespace App\Http\Requests;

class LoginPhoneRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return false;
        return true;
    }

    /**
     * 自定义验证规则rules
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'phone'                 => 'required|size:11',
			'code' 					=> '',
			'phone_code' 			=> 'required_without:code'
        ];
        return $rules;
    }

    /**
     * 自定义验证信息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone.required'              	=> '手机号必填',
            'password.size'                 => '手机长度11位',
            'code.required' 				=> '验证码必填',
			'phone_code.required_without' 	=> '验证码必填'
        ];
    }
}
