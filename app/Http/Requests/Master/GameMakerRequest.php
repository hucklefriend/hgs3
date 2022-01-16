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
            'name'      => 'required|max:200',
            'acronym'   => 'required|max:30',
            'phonetic'  => 'required|max:200',
            'url'       => 'max:300',
            'is_adult'  => ''
        ];
    }
}
