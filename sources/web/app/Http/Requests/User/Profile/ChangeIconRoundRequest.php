<?php
/**
 * アイコン丸み変更リクエスト
 */

namespace Hgs3\Http\Requests\User\Profile;

use Hgs3\Constants\IconRoundType;
use Illuminate\Foundation\Http\FormRequest;

class ChangeIconRoundRequest extends FormRequest
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
            'icon_round_type' => 'required|in:' . IconRoundType::getValidationIn(),
        ];
    }
}
