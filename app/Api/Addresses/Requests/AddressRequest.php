<?php
namespace EQM\Api\Addresses\Requests;

use EQM\Http\Requests\Request;

class AddressRequest extends Request
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
            /*'street' => 'required',
            'zip' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',*/
        ];
    }
}
