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
                'machine_id'            => 'required',  //机器				
            ];
        }else{//store
            $rules = [
				'name'                  => 'required|min:4|max:20',
                'machine_id'            => 'required',  //机器				
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
            'name.required'     	=> '任务名不能为空',
            'name.max'          	=> '任务名过长，长度不得超出20',
            'name.min'           	=> '任务名过短，长度不得少于4',
            'machine_id.required'   => '机器必须选'
        ];
    }
}
