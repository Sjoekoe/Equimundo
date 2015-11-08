<?php
namespace EQM\Http\Controllers\Auth;

use EQM\Http\Controllers\Controller;
use EQM\Models\Users\UserRepository;
use Input;

class ActivationController extends Controller
{
    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    /**
     * @param \EQM\Models\Users\UserRepository $users
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

            session()->put('succes', 'Account activated. You can now login');

            return redirect()->route('login');
        }

        session()->put('error', 'The token does not match.');

        return redirect()->route('home');
    }
}
