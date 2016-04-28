<?php
namespace EQM\Api\Companies\Requests;

use Dingo\Api\Http\FormRequest;
use EQM\Http\Requests\Request;

class StoreCompanyRequest extends FormRequest
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
            'state' => 'required',
            'country' => 'required',
            'website' => 'url_host',
            'email' => 'email|required',
        ];
    }
}
