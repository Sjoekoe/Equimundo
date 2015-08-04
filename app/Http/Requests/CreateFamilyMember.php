<?php namespace EQM\Http\Requests;

use EQM\Http\Requests\Request;

class CreateFamilyMember extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
    public function rules()
    {
        return [
            'name' => 'required',
            'date_of_birth' => 'date_format:Y',
            'date_of_death' => 'date_format:Y',
        ];
    }

}
