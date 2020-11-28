<?php
/**
 * Pixiv保存リクエスト
 */

namespace Hgs3\Http\Requests\User\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SavePixivRequest extends FormRequest
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
            'pixiv_url' => 'required|url|regex:/https:\/\/www.pixiv.net\/member.php\?id=*/',
        ];
    }
}
