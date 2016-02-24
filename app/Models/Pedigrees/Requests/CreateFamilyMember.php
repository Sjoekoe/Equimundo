<?php namespace EQM\Models\Pedigrees\Requests;

use Carbon\Carbon;
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
        $thisYear = Carbon::now()->addYear()->format('Y');
        return [
            'name' => 'required',
            'date_of_birth' => 'date_format:Y|before:' . $thisYear,
            'date_of_death' => 'date_format:Y',
        ];
    }

}
