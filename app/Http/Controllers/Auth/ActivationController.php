<?php
namespace HorseStories\Http\Controllers\Auth;

use HorseStories\Http\Controllers\Controller;
use HorseStories\Models\Users\UserRepository;
use Input;
use Session;

class ActivationController extends Controller
{
    /**
     * @var \HorseStories\Models\Users\UserRepository
     */
    private $users;

    /**
     * @param \HorseStories\Models\Users\UserRepository $users
     */
    function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate()
    {
        $user = $this->users->findByEmail(Input::get('email'));

        if (Input::get('token') == $user->remember_token) {
            $user->activated = true;
            $user->save();

            Session::put('succes', 'Account activated. You can now login');

            return redirect()->route('login');
        }

        Session::put('error', 'The token does not match.');

        return redirect()->route('home');
    }
}
