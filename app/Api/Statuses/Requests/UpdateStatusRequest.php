<?php
namespace EQM\Api\Statuses\Requests;

use EQM\Http\Requests\Request;

class UpdateStatusRequest extends Request
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
