<?php
namespace EQM\Api\Wiki\Articles\Requests;

use EQM\Api\Http\Requests\Request;

class StoreArticleRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'body' => 'required',
        ];
    }
}
