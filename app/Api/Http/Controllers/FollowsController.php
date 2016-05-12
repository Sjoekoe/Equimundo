<?php
namespace EQM\Api\Http\Controllers;

use EQM\Api\Http\Controller;
use EQM\Events\HorseWasFollowed;
use EQM\Models\Horses\Horse;
use EQM\Models\Notifications\Notification;

class FollowsController extends Controller
{
    public function store(Horse $horse)
    {
        $user = auth()->user();

        if ($user->isFollowing($horse)) {
            $user->unFollow($horse);

            $message = trans('copy.p.no_longer_following', ['horse' => $horse->name()]);
        } else {
            $user->follow($horse);

            event(new HorseWasFollowed(
                $horse,
                $user,
                Notification::HORSE_FOLLOWED,
                ['follower' => auth()->user()->fullName(), 'horse' => $horse->name()]
            ));

            $message = trans('copy.p.following', ['horse' => $horse->name()]);
        }

        return response($message);
    }
}
