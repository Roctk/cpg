<?php

namespace App\Api\V1\Requests;

use Config;
use Dingo\Api\Http\FormRequest;

class SubscribeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'course_id' => 'required|exists:courses,id'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
