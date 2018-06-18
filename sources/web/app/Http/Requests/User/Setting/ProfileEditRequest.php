<?php
/**
 * プロフィール変更リクエスト
 */


namespace Hgs3\Http\Requests\User\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileEditRequest extends FormRequest
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
            'name'    => 'required|max:50',
            'profile' => 'max:500',
        ];
    }
}
