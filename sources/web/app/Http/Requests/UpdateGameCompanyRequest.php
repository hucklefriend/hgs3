<?php

namespace Hgs3\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameCompanyRequest extends FormRequest
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
            'id'        => 'required',
            'name'      => 'required|max:100',
            'phonetic'  => 'required|max:100',
            'url'       => 'max:256',
            'wikipedia' => 'max:256'
        ];
    }
}
