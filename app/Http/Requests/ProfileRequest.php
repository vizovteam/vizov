<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfileRequest extends Request
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
            'name' => 'required|min:3|max:60',
            'category_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'address' => 'max:80',
            'phone' => 'max:40',
            'website' => 'max:80',
            'avatar' => 'mimes:jpeg,bmp,png,gif',
        ];
    }
}
