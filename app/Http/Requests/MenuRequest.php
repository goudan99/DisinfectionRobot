<?php

namespace App\Http\Requests;

class MenuRequest extends Request
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
				'name'                  => 'required|min:2|max:20|unique:menus,name',
            ];
        }else{//store
            $rules = [
                'name'                 => 'required|min:2|max:20',
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
            'name.required'      => '请填写菜单名名',
            'name.max'           => '菜单名过长，长度不得超出20',
            'name.min'           => '菜单名过短，长度不得少于2',
            'name.unique'        => '菜单名已存在',
        ];
    }
}
