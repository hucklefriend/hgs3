<?php
/**
 * サイト更新履歴リクエスト
 */

namespace Hgs3\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class EditUpdateHistoryRequest extends FormRequest
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
            'detail' => 'required|max:200',
        ];
    }
}
