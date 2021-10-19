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
                'map_id'              	=> 'required',  //地图必须选
				//'map_area' 				=> 'required',		
                'machine_id'            => 'required',  //机器				
                'start_at'              => 'required',
				//'end_at'              	=> 'required',
				'rate_type'             => 'required',
                //'work'                 	=> 'required',
                'is_clean'             	=> 'boolean',
                'is_test'             	=> 'boolean'
            ];
        }else{//store
            $rules = [
				'name'                  => 'required|min:4|max:100',
                'map_id'              	=> 'required',  //地图必须选
				//'map_area' 				=> 'required',		
                'machine_id'            => 'required',  //机器				
                'start_at'              => 'required',
				//'end_at'              	=> 'required',
				'rate_type'             => 'required',
                //'work'                 	=> 'required',
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
            'map_area.required'     => '地图区域不能为空',
            'machine_id.required'   => '机器必须选',
            'start_at.required'     => '任务开始模式',
            'end_at.required'      	=> '任务结束模式',
            'rate_type.required'	=> '请选择执行频率',
            'work.required'			=> '消毒不能为空',
            'is_clean.boolean'     	=> '扫地必须是0或1',
            'is_test.boolean'      	=> '巡检必须是0或1',
        ];
    }
}
