<?php
namespace EQM\Models\Comments;

use EQM\Models\Statuses\HorseStatus;
use EQM\Models\Users\User;

class CommentPolicy
{
    public function authorize(User $user, Comment $comment)
    {
        if ($comment->poster()->id() == $user->id()) {
            return true;
        }

        return false;
    }

    public function privilege(User $user, Comment $comment)
    {
        if ($comment->poster()->id() == $user->id()) {
            return true;
        }

        if ($comment->status() instanceof HorseStatus) {
            return $user->isInHorseTeam($comment->status()->horse());
        } else {
            return $user->isInCompanyTeam($comment->status()->company());
        }

        return false;
    }
}
