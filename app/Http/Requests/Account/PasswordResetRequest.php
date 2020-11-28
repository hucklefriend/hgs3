<?php
/**
 * パスワードリセットリクエスト
 */

namespace Hgs3\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
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
            'token'                    => 'required',
            'password'                => 'required|string|alpha_dash|min:4|max:16',
            'password_confirmation' => 'required|string|same:password',
        ];
    }
}
