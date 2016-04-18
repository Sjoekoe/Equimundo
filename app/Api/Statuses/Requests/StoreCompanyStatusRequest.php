<?php
namespace EQM\Api\Statuses\Requests;

use EQM\Http\Requests\Request;

class StoreCompanyStatusRequest extends Request
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
            'body' => 'required',
        ];
    }
}
