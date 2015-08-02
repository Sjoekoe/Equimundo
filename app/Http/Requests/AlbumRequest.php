<?php

namespace EQM\Http\Requests;

use EQM\Http\Requests\Request;

class AlbumRequest extends Request
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
            'name' => 'required|between:1,100',
            'pictures' => 'image',
        ];
    }
}
