<?php namespace EQM\Models\Statuses\Requests;

use EQM\Http\Requests\Request;

class PostStatus extends Request {

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
            'horse' => 'required',
            'body' => 'required|max:2000',
            'image' => 'image',
        ];
    }

}
