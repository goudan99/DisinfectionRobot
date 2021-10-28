<?php

namespace App\Http\Requests;

class UserRequest extends Request
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
        if(!$this->id){
			
            $rules = [
                'phone'                 => 'required|size:11|unique:accounts,name',
                'password'              => 'required|min:6|max:16|regex:/^[a-zA-Z0-9~@#%_]{6,16}$/i',  //登录密码只能英文字母(a-zA-Z)、阿拉伯数字(0-9)、特殊符号(~@#%)
				'code' 					=> 'required',				
                'passed'                => 'required|boolean',
				'nickname'              => 'min:1|max:10', 
            ];
        }else{//store
            $rules = [
                'phone'                => 'size:11',
                'password'             => 'nullable|min:6|max:16|regex:/^[a-zA-Z0-9~@#%_]{6,16}$/i',  //登录密码只能英文字母(a-zA-Z)、阿拉伯数字(0-9)、特殊符号(~@#%)		
				'passed'               => 'required|boolean',
                'nickname'             => 'min:1|max:10',
            ];
        }
		
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
            'nickname.required'   => '请填写昵称',
            'nickname.alpha_dash' => '昵称包含特殊字符',
            'nickname.min'        => '昵称过短，长度不得少于1',
            'nickname.max'        => '昵称过长，长度不得超出10',

            'password.required'              => '请填写登录密码',
            'password.min'                   => '密码长度不得少于6',
            'password.max'                   => '密码长度不得超出16',
            'password.regex'                 => '密码包含非法字符，只能为英文字母(a-zA-Z)、阿拉伯数字(0-9)与特殊符号(~@#%_)组合',
            'password_confirmation.required' => '请填写确认密码',
            'password_confirmation.same'     => '2次密码不一致',
			
            'email.required' => '邮箱必填',
            'email.email'   => '请输入正确的邮箱',
			
            'role_id.required' => '请选择角色（用户组）',
            'role_id.exists'   => '系统不存在该角色（用户组）',
			
            'phone.required'     => '请填写手机号码',
            'phone.size'         => '国内的手机号码长度为11位',
            'phone.mobile_phone' => '请填写合法的手机号码',
            'phone.unique'       => '此手机号码已存在于系统中，不能再进行二次关联',

            'passed.required' => '请选择用户状态',
            'passed.boolean'  => '用户状态必须为布尔值',
        ];
    }
}
