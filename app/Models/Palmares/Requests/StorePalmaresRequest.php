<?php
namespace EQM\Models\Palmares\Requests;

use EQM\Http\Requests\Request;

class StorePalmaresRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'event_name' => 'required',
            'ranking' => 'integer|min:0',
            'date' => 'date_format:d/m/Y'
        ];
    }
}
