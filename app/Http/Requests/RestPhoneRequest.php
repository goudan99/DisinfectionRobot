<?php

namespace App\Http\Requests;

class RestPhoneRequest extends Request
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
			'code' 					=> '',
			'phone_code' 			=> 'required_without:code'
			'oldcode' 					=> 'required',
            'phone'                 => 'size:11|unique:users,phone',
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
            'code.required'             	 => '验证码必填',
            'oldcode.required'               => '旧手机验证码必填',
            'phone.required'     => '请填写手机号码',
            'phone.size'         => '国内的手机号码长度为11位',
            'phone.mobile_phone' => '请填写合法的手机号码',
            'phone.unique'       => '此手机号码已存在于系统中，不能再进行二次关联',

        ];
    }
}
