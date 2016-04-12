<?php
namespace EQM\Api\Companies\Requests;

use EQM\Http\Requests\Request;

class StoreCompanyRequest extends Request
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
            'name' => 'required',
            'street' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'website' => 'url_host'
        ];
    }
}
