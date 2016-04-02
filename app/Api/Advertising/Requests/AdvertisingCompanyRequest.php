<?php
namespace EQM\Api\Advertising\Requests;

use EQM\Http\Requests\Request;

class AdvertisingCompanyRequest extends Request
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
            'email' => 'email',
        ];
    }
}
