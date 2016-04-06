<?php
namespace EQM\Api\Advertising\Requests;

use EQM\Http\Requests\Request;

class UpdateAdvertisementRequest extends Request
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'start' => 'date_format:d/m/Y',
            'end' => 'date_format:d/m/Y',
            'type' => 'int',
            'website' => 'url_host',
        ];
    }
}
