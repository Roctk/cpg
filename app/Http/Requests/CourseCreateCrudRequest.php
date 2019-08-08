<?php

namespace App\Http\Requests;


use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\FileBag;

class CourseCreateCrudRequest extends CourseCrudRequest
{
    public function __construct(AuthManager $auth)
    {
        parent::__construct($auth);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['photo'] = 'required';
        return $rules;
    }
}