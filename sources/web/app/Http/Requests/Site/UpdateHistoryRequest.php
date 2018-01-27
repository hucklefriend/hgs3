<?php
/**
 * サイト更新履歴リクエスト
 */

namespace Hgs3\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHistoryRequest extends FormRequest
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
            'site_updated_at' => 'required|date',
            'detail'          => 'required|max:500',
        ];
    }
}
