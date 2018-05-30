<?php
/**
 * レビュー良い点入力リクエスト
 */

namespace Hgs3\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class GoodRequest extends FormRequest
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
            'good_tags'      => 'nullable|array|max:10',
            'very_good_tags' => 'nullable|array|max:10',
            'Good_comment'   => 'nullable|string|max:10000'
        ];
    }
}
