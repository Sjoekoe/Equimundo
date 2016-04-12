<?php
namespace EQM\Api\Companies\Requests;

use EQM\Http\Requests\Request;

class UpdateCompanyRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'website' => 'url_host',
            'email' => 'email',
        ];
    }
}
