<?php
/**
 * ゲーム追加リクエスト
 */


namespace Hgs3\Http\Requests\Game\Request;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
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
            'name' => 'required|max:200',
            'url'  => 'max:250'
        ];
    }

    /**
     * メッセージ
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'nameを入力してください。',
            'name.max' => 'nameは200字以内で入力してください。',
            'url.max' => 'URLは250字以内で入力してください。',
        ];
    }
}
