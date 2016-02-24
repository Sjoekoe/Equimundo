<?php namespace EQM\Models\Users\Requests;

use Carbon\Carbon;
use EQM\Http\Requests\Request;

class UpdateUserProfile extends Request {

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
        $allowedDate = Carbon::now()->subYear(13)->format('d/m/Y');

        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required|date_format:d/m/Y|before:' . $allowedDate,
            'website' => 'url_host',
        ];
    }

}
