<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

class RoleRequest extends Request
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
        //store		
        if($this->segment(4)==="add"){
            $rules = [            
				'name'             	=> 'required|min:2|max:20|unique:roles,name',
            ];
        }else{//store
            $rules = [
                'name'              => 'required|min:2|max:20',
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
            'name.unique'        => '此角色名已存在，请尝试其它名字组合',
            'name.required'      => '请填写角色名',
            'name.max'           => '角色名过长，长度不得超出20',
            'name.min'           => '角色名过短，长度不得少于4',
            'name.unique'        => '此角色已存在，请尝试其它名字组合',
   
            'desc.min'    => '角色描述长度不得少于6',
            'desc.max'    => '角色描述长度不得超出255',
        ];
    }
}
