<?php
/**
 * Created by PhpStorm.
 * User: Vic
 * Date: 04.06.2019
 * Time: 22:54
 */

namespace App\Api\V1\Requests;

use Dingo\Api\Http\FormRequest;

class SupplyRequest extends FormRequest
{
    public function rules()
    {
        return [
            'urgency' => 'required',
            'name' => 'required',
        ];
    }

    public function authorize()
    {
        return true;
    }
}