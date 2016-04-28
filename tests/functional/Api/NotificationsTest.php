<?php
namespace functional\Api;

use EQM\Core\Testing\DefaultIncludes;
use EQM\Models\Notifications\Notification;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotificationsTest extends \TestCase
{
    use DefaultIncludes, DatabaseTransactions;

    /** @test */
    function it_can_get_all_notifications_for_a_user()
    {
        $user = $this->loginAsUser();
        $horse = $this->createHorse();
        $otherUser = $this->createUser(['email' => 'test@test.com']);
        $notification = $this->createNotification([
            'sender_id' => $otherUser->id(),
            'receiver_id' => $user->id(),
            'data' => json_encode([
                'sender' => $otherUser->fullName(),
                'horse' => $horse->name(),
            ]),
        ]);

        $this->actingAs($user)
            ->get('/api/notifications')
            ->seeJsonEquals([
                'data' => [
                    $this->includedNotification($notification),
                ],
                'meta' => [
                    'pagination' => [
                        'count' => 1,
                        'current_page' => 1,
                        'links' => [],
                        'per_page' => 25,
                        'total' => 1,
                        'total_pages' => 1,
                    ],
                ]
            ]);
    }

    /** @test */
    function it_can_mark_all_notifications_as_read()
    {
        $user = $this->loginAsUser();
        $horse = $this->createHorse();
        $otherUser = $this->createUser(['email' => 'test@test.com']);
        $notification = $this->createNotification([
            'sender_id' => $otherUser->id(),
            'receiver_id' => $user->id(),
            'data' => json_encode([
                'sender' => $otherUser->fullName(),
                'horse' => $horse->name(),
            ]),
        ]);

        $this->actingAs($user)
            ->get('/api/notifications/mark-as-read')
            ->seeJsonEquals([
                'data' => [
                    $this->includedNotification($notification, ['is_read' => true]),
                ],
                'meta' => [
                    'pagination' => [
                        'count' => 1,
                        'current_page' => 1,
                        'links' => [],
                        'per_page' => 25,
                        'total' => 1,
                        'total_pages' => 1,
                    ],
                ]
            ]);
    }

    /** @test */
    function it_can_show_a_notification()
    {
        $user = $this->loginAsUser();
        $horse = $this->createHorse();
        $otherUser = $this->createUser(['email' => 'test@test.com']);
        $notification = $this->createNotification([
            'sender_id' => $otherUser->id(),
            'receiver_id' => $user->id(),
            'data' => json_encode([
                'sender' => $otherUser->fullName(),
                'horse' => $horse->name(),
            ]),
        ]);

        $this->actingAs($user)
            ->get('/api/notifications/' . $notification->id())
            ->seeJsonEquals([
                'data' => $this->includedNotification($notification),
            ]);
    }

    /** @test */
    function it_can_delete_a_notification()
    {
        $user = $this->loginAsUser();
        $horse = $this->createHorse();
        $otherUser = $this->createUser(['email' => 'test@test.com']);
        $notification = $this->createNotification([
            'sender_id' => $otherUser->id(),
            'receiver_id' => $user->id(),
            'data' => json_encode([
                'sender' => $otherUser->fullName(),
                'horse' => $horse->name(),
            ]),
        ]);

        $this->actingAs($user)
            ->delete('api/notifications/' . $notification->id())
            ->assertResponseStatus(204);

        $this->missingFromDatabase(Notification::TABLE, [
            'id' => $notification->id(),
        ]);
    }
}
