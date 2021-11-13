<?php

namespace App\Http\Requests;

class JobRequest extends Request
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
        if(!$this->id){
			
            $rules = [            
				'name'                  => 'required|min:2|max:100',
                'map_id'              	=> 'required|numeric',  //地图必须选
                'machine_id'            => 'required|numeric',  //机器				
                'start_at'              => 'required|date|after:now',
				'rate_type'             => 'required|numeric',
                'is_clean'             	=> 'boolean',
                'is_test'             	=> 'boolean'
            ];
        }else{//store
            $rules = [
				'name'                  => 'min:2|max:100',
                'map_id'              	=> 'numeric',  //地图必须选
                'machine_id'            => 'numeric',  //机器				
                'start_at'              => 'date|after:now',
				'rate_type'             => 'numeric',
                'is_clean'             	=> 'boolean',
                'is_test'             	=> 'boolean'
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
            'name.min'           	=> '任务名过短，长度不得少于2',
            'map_id.required'      	=> '地图不能为空',
            'map_id.numeric'      	=> '地图必须为数字',
            'map_area.required'     => '地图区域不能为空',
            'machine_id.required'   => '机器必须选',
            'machine_id.numeric'   	=> '机器id必须为数字',
            'start_at.required'     => '任务开始模式',
            'start_at.date'     	=> '必须为时间格式',
            'start_at.after'     	=> '必须在当前时间之后',
            'end_at.required'      	=> '任务结束模式',
            'rate_type.required'	=> '请选择执行频率',
            'rate_type.numeric'   	=> '执行频率必须为数字',
            'work.required'			=> '消毒不能为空',
            'is_clean.boolean'     	=> '扫地必须是0或1',
            'is_test.boolean'      	=> '巡检必须是0或1',
        ];
    }
}
