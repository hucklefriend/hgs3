<?php
/**
 * ゲームメーカーリクエスト
 */

namespace Hgs3\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class GameMakerRequest extends FormRequest
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
            'name'      => 'required|max:200',
            'acronym'   => 'required|max:30',
            'phonetic'  => 'required|max:200',
            'url'       => 'max:512',
            'wikipedia' => 'max:512',
            'is_adult'  => ''
        ];
    }
}
