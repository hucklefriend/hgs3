<?php
/**
 * ゲームソフトリクエスト
 */

namespace Hgs3\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class GameSoftRequest extends FormRequest
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
            'name'         => 'required|max:200',
            'phonetic'     => 'required|max:200',
            'phonetic2'    => 'required|max:200',
            'genre'        => 'nullable|max:200',
            'series_id'    => 'nullable|exists:game_series,id',
            'order_in_series' => 'nullable|max:200',
            'franchise_id' => 'required|exists:game_franchises,id',
            'original_package_id' => 'nullable|exists:game_packages,id',
            'introduction' => 'nullable|max:1000',
            'introduction_from' => 'required_with:introduction|max:1000',
            'introduction_from_adult' => 'nullable|boolean',
            'adult_only_flag' => 'nullable|boolean',
        ];
    }
}
