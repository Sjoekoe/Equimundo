<?php
namespace EQM\Models\Comments;

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
        if ($comment->poster()->id() == $user->id() || $user->isInHorseTeam($comment->status()->horse())) {
            return true;
        }

        return false;
    }
}
