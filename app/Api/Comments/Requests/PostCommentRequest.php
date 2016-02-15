<?php
namespace EQM\Api\Comments\Requests;

use EQM\Http\Requests\Request;

class PostCommentRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'body' => 'required',
        ];
    }
}
