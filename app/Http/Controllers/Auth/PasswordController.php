<?php
namespace EQM\Http\Controllers\Auth;

use EQM\Http\Controllers\Controller;
use EQM\Models\Users\Requests\UpdatePasswordRequest;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller {
    use ResetsPasswords;

    /**
     * @var string
     */
    protected $redirectTo = '/';

    public function edit()
    {
        return view('auth.edit_password');
    }

    public function update(UpdatePasswordRequest $request, Hasher $hasher)
    {
        if ($hasher->check($request->get('old_password'), auth()->user()->getAuthPassword())) {
            auth()->user()->password = bcrypt($request->get('password'));

            auth()->user()->save();

            session()->put('success', 'Your password has been changed');
        } else {
            session()->put('error', 'Please try again. The password you provided doesn\'t match your old password.');
        }
        return redirect()->route('password.update');
    }
}
