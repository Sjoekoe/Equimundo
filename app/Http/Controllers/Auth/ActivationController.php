<?php
namespace EQM\Http\Controllers\Auth;

use EQM\Http\Controllers\Controller;
use EQM\Models\Users\UserRepository;
use Illuminate\Http\Request;

class ActivationController extends Controller
{
    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function activate(Request $request)
    {
        $user = $this->users->findByEmail($request->get('email'));

        if ($user && ($request->get('token') == $user->activationKey())) {
            $this->users->activate($user);

            session()->put('success', 'Account activated. You can now login');

            return redirect()->route('login');
        }

        session()->put('error', 'The token does not match.');

        return redirect()->route('home');
    }
}
