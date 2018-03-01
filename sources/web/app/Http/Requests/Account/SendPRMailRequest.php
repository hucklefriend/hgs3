<?php
/**
 * 仮登録メール送信リクエスト
 */

namespace Hgs3\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class SendPRMailRequest extends FormRequest
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
        return [
            'email' => 'required|string|email|max:255|unique:users,email'
        ];
    }
}
