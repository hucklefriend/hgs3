<?php

namespace Hgs3\Http\Requests\User\SiteManage;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            'list_banner_upload_flag'   => 'required|in:0,1,2,3',
            'list_banner_url'           => 'required_if:list_banner_upload_flag,1|nullable|url|regex:/https*/',
            'list_banner_upload'        => 'file|image|max:1024|required_if:list_banner_upload_flag,2',
            'detail_banner_upload_flag' => 'required|in:0,1,2,3',
            'detail_banner_url'         => 'required_if:detail_banner_upload_flag,1|nullable|url|regex:/https*/',
            'detail_banner_upload'      => 'file|image|max:3072|required_if:detail_banner_upload_flag,2',
            'go_to_r18'                 => 'nullable'
        ];
    }
}
