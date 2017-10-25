<?php
/**
 * サイトリクエスト
 */

namespace Hgs3\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class SiteRequest extends FormRequest
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
            'name'               => 'required|max:100',
            'url'                => 'required|max:300|url',
            'handle_game'        => 'required',
            'presentation'       => 'required|max:1000',
            'list_banner_url'    => 'max:200|url',
            'list_banner_upload' => 'file|image|site:1024',
        ];
    }
}
