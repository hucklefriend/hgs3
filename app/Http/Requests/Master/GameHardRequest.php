<?php
/**
 * ゲームハードリクエスト
 */

namespace Hgs3\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class GameHardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'       => 'required|max:200',
            'phonetic'   => 'required|max:200',
            'acronym'    => 'required|max:10',
            'sort_order' => 'required|integer|min:0|max:99999999',
            'maker_id'   => 'nullable|exists:game_companies,id'
        ];
    }
}
