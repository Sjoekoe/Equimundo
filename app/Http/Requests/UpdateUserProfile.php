<?php namespace EQM\Http\Requests;

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
		return [
			'date_of_birth' => 'date|date_format:d/m/Y'
		];
	}

}
