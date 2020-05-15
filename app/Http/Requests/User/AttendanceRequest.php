<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AttendanceRequest extends FormRequest
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
        if ($request['type'] === 'modify') {
            return [
                'date' => 'required|before_or_equal:now',
                'modify_content' => 'required|max:500'
            ];
        } else {
            return [
                'absent_content' => 'required|max:500'
            ];
        }
    }

    /**
     * custom message
     *
     * @return array
     */
    public function messages()
    {
        return [
            'before_or_equal' => '今日以前の日付を選択してください。',
            'required' => '入力必須の項目です。',
            'max' => ':max文字以内で入力してください。'
        ];
    }
}
