<?php
namespace EQM\Api\Statuses\Requests;

use EQM\Http\Requests\Request;

class StoreStatusRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'horse' => 'required',
            'body' => 'required',
        ];
    }
}
