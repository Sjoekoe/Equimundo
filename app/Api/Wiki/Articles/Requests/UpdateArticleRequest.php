<?php
namespace EQM\Api\Wiki\Articles\Requests;

use EQM\Api\Http\Requests\Request;

class UpdateArticleRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'min:10|max:50',
            'body' => 'min:10',
        ];
    }
}
