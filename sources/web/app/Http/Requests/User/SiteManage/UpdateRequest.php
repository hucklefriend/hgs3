<?php

namespace Hgs3\Http\Requests\User\SiteManage;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'list_banner_edit'     => 'required|in:1,2,3',
            'list_banner_upload'   => 'required_if:list_banner_edit,2|file|image|max:1024',
            'detail_banner_edit'   => 'required|in:1,2,3',
            'detail_banner_upload' => 'required_if:detail_banner_edit,2|file|image|max:3072',
            'draft'                => 'nullable',
        ];
    }
}
