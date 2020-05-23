<?php

namespace App\Http\Requests\User\Attendance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AbsentRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $request = $request->all();
        return [
            'absent_content' => 'required|max:500'
        ];
    }

    /**
     * custom message
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => '入力必須の項目です。',
            'max' => ':max文字以内で入力してください。'
        ];
    }
}
