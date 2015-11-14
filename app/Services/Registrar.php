<?php namespace EQM\Services;

use EQM\Models\Users\UserCreator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use Validator;

class Registrar implements RegistrarContract {
	/**
	 * @var \EQM\Models\Users\UserCreator
	 */
	private $userCreator;

	/**
	 * @param \EQM\Models\Users\UserCreator $userCreator
	 */
    public function __construct(UserCreator $userCreator)
	{
		$this->userCreator = $userCreator;
	}

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
	 * @return EloquentUser
	 */
	public function create(array $data)
	{
		$user = $this->userCreator->create($data);

        return $user;
	}

}
