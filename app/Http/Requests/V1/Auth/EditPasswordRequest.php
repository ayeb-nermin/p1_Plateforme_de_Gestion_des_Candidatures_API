<?php

namespace App\Http\Requests\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class EditPasswordRequest extends FormRequest
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
            // 'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
        ];

        return $rules;
    }


    public function messages()
    {

        $messages = [
            'password.required' => __('messages.errors.password_required'),
            'password.min' => __('messages.errors.password_min'),
            'password.max' => __('messages.errors.password_max'),
            'password.regex' => __('messages.errors.password_regex'),
            'password.confirmed' => __('messages.errors.password_confirmed'),
        ];

        return $messages;
    }
}
