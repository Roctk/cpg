<?php
/**
 * Created by PhpStorm.
 * User: Vic
 * Date: 04.06.2019
 * Time: 22:54
 */

namespace App\Api\V1\Requests;


use Dingo\Api\Http\FormRequest;

class CleaningServiceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'type' => 'required',
            'area' => 'required|numeric',
            'surface_type' => 'required',
            'urgency' => 'required'
        ];
    }

    public function authorize()
    {
        return true;
    }
}