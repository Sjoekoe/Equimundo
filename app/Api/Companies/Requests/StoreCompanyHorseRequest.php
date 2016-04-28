<?php
namespace EQM\Api\Companies\Requests;

use EQM\Http\Requests\Request;

class StoreCompanyHorseRequest extends Request
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
            'horse_id' => 'required',
        ];
    }
}
