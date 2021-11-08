<?php

namespace App\Http\Requests;

class FreedbackRequest extends Request
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
			'desc'                  => 'required|min:5',
			'phone'                 => 'required|max:50',
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
            'desc.required'      => '问题描述必填',
            'desc.min'           => '问题描述不能少于5个字',
            'phone.required'     => '联系方式必填',
            'phone.max'          => '联系方式长度超过50个'
        ];
    }
}
