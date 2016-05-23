<?php
namespace EQM\Api\Wiki\Topics\Requests;

use EQM\Api\Http\Requests\Request;

class StoreTopicRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
        ];
    }
}
