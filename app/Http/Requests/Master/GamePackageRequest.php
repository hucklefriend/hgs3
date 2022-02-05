<?php
/**
 * ゲームパッケージリクエスト
 */

namespace Hgs3\Http\Requests\Master;

use Hgs3\Enums\RatedR;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GamePackageRequest extends FormRequest
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
            'acronym'      => 'required|max:30',
            'platform_id'  => 'required|exists:game_platforms,id',
            'company_id'   => 'required|exists:game_companies,id',
            'release_at'   => 'required|max:100',
            'release_int'  => 'required|numeric|integer|min:0|max:99999999',
            'is_adult'     => ['required', Rule::in(RatedR::cases())],

            //'series_id'    => 'nullable|exists:game_series,id',
        ];
    }
}
