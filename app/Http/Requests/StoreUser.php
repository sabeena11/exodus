<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends CoreRequest
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
            'name' => 'required',
            // 'password' => 'required|min:6',
            'image' => 'image|max:2048',
            'mobile' => 'required|unique:users',
            'dob' => 'required',
            'address' => 'required',
            'sex' => 'required'
        ];
    }
}
