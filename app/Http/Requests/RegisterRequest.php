<?php

namespace App\Http\Requests;

class RegisterRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'phone'              			=> 'required|size:11|unique:accounts,name',						// 手机号
			'phone_code' 					=> 'required',													// 手机验证码
			'invite_code' 					=> 'required',													// 邀请码
			'wechat_code' 					=> 'required',													// 小程序code码，用于获取用户openid
            'password'              		=> 'required|min:6|max:16|regex:/^[a-zA-Z0-9~@#%_]{6,16}$/i',	// 登录密码只能英文字母(a-zA-Z)、阿拉伯数字(0-9)、特殊符号(~@#%)
            'password_confirmation' 		=> 'required|same:password',									// 确认密码
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
            'phone.required'              	=> '手机号码必须填',
			'phone.size'              		=> '手机号码长度必须为11位',
			'phone.unique'              	=> '该手机已注册',
            'password.required'             => '请填写登录密码',
            'password.min'                  => '密码长度不得少于6',
            'password.max'                  => '密码长度不得超出16',
            'password.regex'                => '密码包含非法字符，只能为英文字母(a-zA-Z)、阿拉伯数字(0-9)与特殊符号(~@#%_)组合',
            'password_confirmation.required'=> '请填写确认密码',
            'password_confirmation.same'	=> '2次密码不一致',
            'phone_code.required' 			=> '验证码必填',
            'invite_code.required'			=> '邀请码必填',
        ];
    }
}
