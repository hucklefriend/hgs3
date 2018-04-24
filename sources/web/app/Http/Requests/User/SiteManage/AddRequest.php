<?php

namespace Hgs3\Http\Requests\User\SiteManage;

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
            'name'                 => 'required|max:100',
            'url'                  => 'required|max:300|url',
            'handle_soft'          => 'required',
            'presentation'         => 'max:1000',
            'list_banner_upload'   => 'file|image|max:1024',
            'detail_banner_upload' => 'file|image|max:3072',
            'draft'                => 'nullable',
            'hgs2_site_id'         => ''
        ];
    }
}
