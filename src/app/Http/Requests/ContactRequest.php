<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'title' => 'required|max:255',
            'detail' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前は必須です',
            // 'email.required' => '名前は必須です',
            // 'email.email' => 'メールアドレスの形式が正しくありません',
            'title.required' => '件名は必須です',
            'title.max:255' => '255文字以内で入力をお願いいたします',
            'detail.required' => '内容は必須です'
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'メールアドレス',
            //messagesにないのでデフォルト（lang/ja/validation.php）の「〜必須です。」が使われる
        ];
    }


}
