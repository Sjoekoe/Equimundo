<?php namespace EQM\Services;

use EQM\Models\Users\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'firstname' => 'required|max:255|unique:users',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		$user =  User::create([
			'firstname' => $data['username'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'date_format' => 'd/m/Y',
			'language' => 'en',
			'email_notifications' => true,
		]);

        $user->assignRole(1);

        return $user;
	}

}
