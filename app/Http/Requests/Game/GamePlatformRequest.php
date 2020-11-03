<?php
/**
 * プラットフォームリクエスト
 */

namespace Hgs3\Http\Requests\Game;

use Illuminate\Foundation\Http\FormRequest;

class GamePlatformRequest extends FormRequest
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
            'name'       => 'required|max:100',
            'acronym'    => 'required|max:100',
            'company_id' => 'required',
            'sort_order' => 'required|integer',
            'url'        => 'max:500',
            'wikipedia'  => 'max:500'
        ];
    }
}
