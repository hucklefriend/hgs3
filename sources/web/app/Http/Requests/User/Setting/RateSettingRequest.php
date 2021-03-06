<?php
/**
 * R-18表示リクエスト
 */


namespace Hgs3\Http\Requests\User\Setting;

use Illuminate\Foundation\Http\FormRequest;

class RateSettingRequest extends FormRequest
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
            'adult' => 'nullable|boolean'
        ];
    }
}
