<?php
namespace EQM\Http\Controllers\Statuses;

use DB;
use EQM\Events\StatusLiked;
use EQM\Models\Notifications\Notification;
use EQM\Models\Statuses\StatusRepository;
use Illuminate\Routing\Controller;

class LikeController extends Controller
{
    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     */
    public function __construct(StatusRepository $statuses)
    {
        $this->statuses = $statuses;
    }

    /**
     * @param int $status
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function like($status)
    {
        $status = $this->statuses->findById($status);

        $likes = DB::table('likes')->whereUserId(auth()->user()->id)->lists('status_id');

        if (in_array($status->id(), $likes)) {
            auth()->user()->likes()->detach($status);
        } else {
            auth()->user()->likes()->attach($status);

            $data = ['sender' => auth()->user()->fullName(), 'horse' => $status->horse()->name];

            event(new StatusLiked($status, auth()->user(), Notification::STATUS_LIKED, $data));
        }

        return response()->json('success', 200);
    }
}
