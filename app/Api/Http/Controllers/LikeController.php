<?php
namespace EQM\Api\Http\Controllers;

use EQM\Api\Http\Controller;
use EQM\Api\Statuses\StatusTransformer;
use EQM\Models\Comments\Comment;
use EQM\Models\Statuses\Likes\LikeHandler;
use EQM\Models\Statuses\Status;

class LikeController extends Controller
{
    public function like(LikeHandler $handler, Status $status)
    {
        $status = $handler->handleStatus($status, auth()->user());

        return $this->response()->item($status, new StatusTransformer());
    }

    public function likeComment(LikeHandler $handler, Comment $comment)
    {
        $handler->handleComment($comment, auth()->user());

        return response()->json('success', 200);
    }
}
