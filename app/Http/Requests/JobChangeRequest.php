<?php

namespace App\Http\Requests;

class JobChangeRequest extends Request
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
			'id'                  	=> 'required|array',
			'status'             	=> 'required|numeric',
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
            'id.required'     		=> '任务名不能为空',
            'id.array'          	=> '任务名过长，长度不得超出20',
            'status.required'      	=> '状态不能为空',
            'status.numeric'      	=> 'status必须为数字',
        ];
    }
}
