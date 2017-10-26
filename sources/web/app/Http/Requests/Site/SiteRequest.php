<?php
/**
 * サイトリクエスト
 */

namespace Hgs3\Http\Requests\Site;

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
            'name'                      => 'required|max:100',
            'url'                       => 'required|max:300|url',
            'handle_soft'               => 'required',
            'presentation'              => 'required|max:1000',
            'list_banner_upload_flag'   => 'required',
            'list_banner_url'           => 'required_if:list_banner_upload_flag,1|nullable|max:200|url',
            'list_banner_upload'        => 'required_if:list_banner_upload_flag,2|file|image|max:1024',
            'detail_banner_upload_flag' => 'required',
            'detail_banner_url'         => 'required_if:detail_banner_upload_flag,1|nullable|max:200|url',
            'detail_banner_upload'      => 'required_if:detail_banner_upload_flag,2|file|image|max:1024',
        ];
    }
}
