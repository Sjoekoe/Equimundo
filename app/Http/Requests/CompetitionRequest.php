<?php
namespace EQM\Http\Requests;

use EQM\Models\Competitions\Competition;

class CompetitionRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'q1' => 'required',
            'q2' => 'required',
            'q3' => 'required',
            'email' => 'email|required|unique:' . Competition::TABLE,
            'name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Er is reeds een inzending gebeurd met dit mail adres.',
        ];
    }
}
