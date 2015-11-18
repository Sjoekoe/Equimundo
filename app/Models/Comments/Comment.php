<?php
namespace EQM\Models\Comments;

interface Comment
{
    const POLICIES = [
        'delete-comment', 'edit-comment',
    ];

    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function body();

    /**
     * @return \EQM\Models\Users\User
     */
    public function poster();

    /**
     * @return \EQM\Models\Statuses\Status
     */
    public function status();
}
