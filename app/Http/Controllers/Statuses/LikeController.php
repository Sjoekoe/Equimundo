<?php
namespace EQM\Http\Controllers\Statuses;

use EQM\Http\Controllers\Controller;
use EQM\Models\Statuses\Likes\LikeHandler;
use EQM\Models\Statuses\Status;

class LikeController extends Controller
{
    public function like(LikeHandler $handler, Status $status)
    {
        $handler->handle($status, auth()->user());

        return response()->json('success', 200);
    }
}
