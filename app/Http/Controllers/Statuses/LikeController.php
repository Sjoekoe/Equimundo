<?php
namespace HorseStories\Http\Controllers\Statuses;

use Auth;
use DB;
use HorseStories\Events\StatusLiked;
use HorseStories\Models\Notifications\Notification;
use HorseStories\Models\Statuses\Status;
use Illuminate\Routing\Controller;

class LikeController extends Controller
{
    /**
     * @param int $status
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function like($status)
    {
        $status = Status::findOrFail($status);

        $likes = DB::table('likes')->whereUserId(Auth::user()->id)->lists('status_id');

        if (in_array($status->id, $likes)) {
            Auth::user()->likes()->detach($status);
        } else {
            Auth::user()->likes()->attach($status);

            $data = ['sender' => Auth::user()->username, 'horse' => $status->horse->name];

            event(new StatusLiked($status, Auth::user(), Notification::STATUS_LIKED, $data));
        }

        return response()->json('success', 200);
    }
}
