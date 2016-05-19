<?php
namespace EQM\Http\Controllers\Auth\Social;

use EQM\Http\Controllers\Controller;
use EQM\Models\Users\Social\TwitterAccountCreator;
use Socialite;

class TwitterController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function callback(TwitterAccountCreator $creator)
    {
        $twitterUser = Socialite::driver('twitter')->user();

        $user = $creator->createOrGetUser($twitterUser);

        auth()->login($user);

        return redirect()->route('home');
    }
}
