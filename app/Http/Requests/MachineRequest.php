<?php

namespace App\Http\Requests;

class MachineRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
			
        $rules = [            
			'name'                  => 'required|min:1|max:255',		
			'sn'            		=> 'required',  //机器
			'power_setting'         => 'numeric',  //机器
			'move_speed'            => 'numeric',  //机器
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
            'name.required'     	=> '机器名必填',
            'sn.required'          	=> '机器sn必写',
            'power_setting.numeric'   => '充电设置必须为数字',
            'move_speed.numeric'   	=> '移动速度必须为数字'
        ];
    }
}
