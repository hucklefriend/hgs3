<?php
/**
 * ゲーム会社追加リクエスト
 */

namespace Hgs3\Http\Requests\Game;

use Illuminate\Foundation\Http\FormRequest;

class GameCompanyRequest extends FormRequest
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
            'name'      => 'required|max:100',
            'phonetic'  => 'required|max:100',
            'url'       => 'max:512',
            'wikipedia' => 'max:512'
        ];
    }
}
