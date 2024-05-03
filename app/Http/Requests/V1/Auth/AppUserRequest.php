<?php

namespace App\Http\Requests\V1\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AppUserRequest extends FormRequest
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

        $rules = [
            // 'name' => 'nullable',
            'email' => 'nullable',
            'password' => 'required',
        ];
        if (str_contains(request()->route()->getActionMethod(), 'register')) {

            $rules['email'] =  'required|unique:users';
        }

        return $rules;
    }
}
