<?php
namespace EQM\Http\Controllers\Statuses;

use EQM\Http\Controllers\Controller;
use EQM\Models\Comments\Comment;
use EQM\Models\Statuses\Likes\LikeHandler;
use EQM\Models\Statuses\Status;
use Redirect;
use URL;

class LikeController extends Controller
{
    public function like(LikeHandler $handler, Status $status)
    {
        $handler->handleStatus($status, auth()->user());

        return Redirect::to(URL::previous() . "#" . $status->id());
    }

    public function likeComment(LikeHandler $handler, Comment $comment)
    {
        $handler->handleComment($comment, auth()->user());

        return response()->json('success', 200);
    }
}
