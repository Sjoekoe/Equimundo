<?php
namespace EQM\Api\Advertising\Requests;

use EQM\Http\Requests\Request;

class AdvertisementRequest extends Request
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
            'amount' => 'required',
            'start' => 'required|date_format:d/m/Y',
            'end' => 'required|date_format:d/m/Y',
            'company_id' => 'required',
            'type' => 'int|required',
            'website' => 'required|url_host',
        ];
    }
}
