<?php

namespace App\Http\Requests;

class MapRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        if(!$this->id){
			
            $rules = [            
				'name'                  => 'required|min:4|max:20',		
                'machine_id'            => 'required|numeric',  //机器			
            ];
        }else{//store
            $rules = [
				'name'                  => 'required|min:4|max:20',
                'machine_id'            => 'required|numeric',  //机器				
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
            'name.required'     	=> '地图名不能为空',
            'name.max'          	=> '地图名过长，长度不得超出20',
            'name.min'           	=> '地图名过短，长度不得少于4',
            'machine_id.required'   => '机器必须选',
            'machine_id.numeric'   	=> '机器id必须为数字'
        ];
    }
}
