<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProjectRequest extends Request
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:5|max:80',
            'category_id' => 'required|numeric',
            'price' => 'max:10',
            'files' => 'mimes:jpeg,png,svg,svgs,bmp,gif,odt,ods,odp,doc,docx,xlsx,xls,ppt,pptx,txt,pdf',
            'city_id' => 'required|numeric',
            'address' => 'max:80',
            'phone' => 'required|min:5|max:40',
            'email' => 'required|max:40'
        ];
    }
}
