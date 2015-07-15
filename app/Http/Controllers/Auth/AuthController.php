<?php
namespace HorseStories\Http\Controllers\Auth;

use HorseStories\Events\UserRegistered;
use HorseStories\Http\Controllers\Controller;
use HorseStories\Models\Settings\Setting;
use HorseStories\Models\Users\User;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Validator;

class AuthController extends Controller {

	use AuthenticatesAndRegistersUsers;

    public $redirectTo = '/';

    public $loginPath = '/login';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'getLogout']);
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
            'username' => 'required|max:255|unique:users',
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
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $user->assignRole(1);

        $settings = new Setting();
        $settings->user_id = $user->id;
        $settings->date_format = 'd/m/Y';
        $settings->language = 'en';
        $settings->save();

        event(new UserRegistered($user));

        return $user;
    }
}
