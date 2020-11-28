<?php
/**
 * SNS公開リクエスト
 */

namespace Hgs3\Http\Requests\User\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SnsOpenRequest extends FormRequest
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
            'open_flag' => 'required|in:0,1',
        ];
    }
}
