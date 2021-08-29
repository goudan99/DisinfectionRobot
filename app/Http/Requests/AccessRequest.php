<?php

namespace App\Http\Requests;

class AccessRequest extends Request
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
			'name'                  => 'required',
			'code'             		=> 'required',
			'path' 					=> 'required',				
			'method'               	=> 'required'
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
            'name.required'      => '功能名不能空',
            'code.required'      => '功能编号不能空',
            'path.required'      => '路径不能空',
            'path.required'      => '方法不能为空',
        ];
    }
}
