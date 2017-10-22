<?php
/**
 * ゲームパッケージリクエスト
 */

namespace Hgs3\Http\Requests\Game;

use Illuminate\Foundation\Http\FormRequest;

class GamePackageRequest extends FormRequest
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
            //'name'       => 'required|max:200',
            //'phonetic'   => 'required|max:200',
            //'genre'      => 'max:200'
        ];
    }
}
