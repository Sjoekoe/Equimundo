<?php
namespace EQM\Api\Conversations\Messages\Requests;

use EQM\Api\Http\Requests\Request;

class StoreMessageRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required',
        ];
    }
}
