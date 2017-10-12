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

    public function messages()
    {
        return [
            'email.required' => 'Er, you forgot your email address!',
            'email.unique' => 'Email already taken m8',
        ];
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
            'progress' => 'required|max:300',
            'text'     => 'required|max:10000'
        ];
    }
}
