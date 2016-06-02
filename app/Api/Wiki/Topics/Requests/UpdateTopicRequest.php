<?php
namespace EQM\Api\Wiki\Topics\Requests;

use EQM\Api\Http\Requests\Request;

class UpdateTopicRequest extends Request
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
