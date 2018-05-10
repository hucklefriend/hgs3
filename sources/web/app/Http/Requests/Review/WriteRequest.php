<?php
/**
 * レビュー投稿リクエスト
 */

namespace Hgs3\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class WriteRequest extends FormRequest
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
            'soft_id'         => 'required|exists:game_softs,id',
            'progress'        => 'nullable|string|max:300',
            'fear'            => 'required|integer|between:-30,30',
            'good_tags'       => 'nullable|array',
            'very_good_tags'  => 'nullable|array',
            'bad_tags'        => 'nullable|array',
            'ver_bad_tags'    => 'nullable|array',
            'good_comment'    => 'nullable|string|max:10000',
            'bad_comment'     => 'nullable|string|max:10000',
            'general_comment' => 'nullable|string|max:10000',
            'is_spoiler'      => 'nullable|integer|between:0,1'
        ];
    }
}
