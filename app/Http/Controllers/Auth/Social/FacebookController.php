<?php
namespace EQM\Http\Controllers\Auth\Social;

use EQM\Http\Controllers\Controller;
use EQM\Models\Users\Social\FaceBookAccountCreator;
use Socialite;

class FacebookController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->fields([
            'first_name', 'last_name', 'email', 'gender', 'birthday', 'hometown'
        ])->scopes([
            'email', 'user_birthday', 'user_hometown'
        ])->redirect();
    }

    public function callback(FaceBookAccountCreator $creator)
    {
        $facebookUser = Socialite::driver('facebook')->fields([
            'first_name', 'last_name', 'email', 'gender', 'birthday', 'hometown'
        ])->user();

        $user = $creator->createOrGetUser($facebookUser);

        auth()->login($user);

        return redirect()->route('home');
    }
}
