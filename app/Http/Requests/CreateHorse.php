<?php namespace HorseStories\Http\Requests;

use HorseStories\Http\Requests\Request;

class CreateHorse extends Request {

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
            'date_of_birth' => 'date_format:d/m/Y',
            'life_number' => 'unique:horses',
            'profile_pic' => 'image'
		];
	}

}
