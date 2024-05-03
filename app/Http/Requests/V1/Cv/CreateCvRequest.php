<?php

namespace App\Http\Requests\V1\Cv;

use Illuminate\Foundation\Http\FormRequest;

class CreateCvRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'user_id' => 'required',
        ];
    }
}
