<?php
namespace functional\Api;

use EQM\Core\Testing\DefaultIncludes;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersTest extends \TestCase
{
    use DefaultIncludes, DatabaseTransactions;

    /** @test */
    function it_can_show_a_user()
    {
        $user = $this->createUser();

        $this->get('/api/users/' . $user->id())
            ->seeJsonEquals(
                $this->includedUser($user)
            );
    }

    /** @test */
    function it_can_reset_the_notification_count_of_a_user()
    {
        $user = $this->createUser(['unread_notifications' => 5]);

        $this->get('/api/users/' . $user->id() . '/notifications/reset-count')
            ->seeJsonEquals(
                $this->includedUser($user, ['unread_notifications' => 0])
            );
    }
}
