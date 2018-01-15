<?php
/**
 * システム更新履歴リクエスト
 */

namespace Hgs3\Http\Requests\System;

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
            'title'     => 'required|max:100',
            'detail'    => 'required',
            'update_at' => 'required|date',
        ];
    }
}
