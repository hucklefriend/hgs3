<?php
/**
 * プロフィール公開範囲設定リクエスト
 */


namespace Hgs3\Http\Requests\User\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileOpenSettingRequest extends FormRequest
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
            'flag' => 'required|in:0,1,2'
        ];
    }
}
