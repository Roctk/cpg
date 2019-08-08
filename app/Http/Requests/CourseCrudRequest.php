<?php

namespace App\Http\Requests;


use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\FileBag;

class CourseCrudRequest extends FormRequest
{
    /**
     * @var AuthManager
     */
    private $auth;

    public function __construct(AuthManager $auth)
    {
        parent::__construct();
        $this->auth = $auth;
    }

    public function authorize()
    {
        // only allow updates if the user is logged in
        return $this->auth->guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'date_time' => 'required|date',
            'date_time_end' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Введите имя',
            'description.required' => 'Введите описание',
            'price.required' => 'Введите цену',
            'date_time.required' => 'Введите дату начала',
            'date_time_end.required' => 'Введите дату окончания',
            'photo.required' => 'Выберите фото',
            'price.numeric' => 'Не числовое значение цены',
            'date_time.date' => 'Неверный формат даты',
            'date_time_end.date' => 'Неверный формат даты'
        ];
    }

    public function resetFiles()
    {
        $this->files = new FileBag();
        $this->convertedFiles = [];
    }
}