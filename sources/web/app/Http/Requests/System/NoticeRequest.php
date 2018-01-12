<?php
/**
 * お知らせリクエスト
 */

namespace Hgs3\Http\Requests\System;

use Illuminate\Foundation\Http\FormRequest;

class NoticeRequest extends FormRequest
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
            'title'    => 'required|max:100',
            'message'  => 'required',
            'open_at'  => 'required|date',
            'close_at' => 'required|date'
        ];
    }
}
