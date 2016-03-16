<?php
namespace functional\Api;

use DB;
use EQM\Core\Testing\DefaultIncludes;
use EQM\Models\Notifications\Notification;

class NotificationsTest extends \TestCase
{
    use DefaultIncludes;

    /** @test */
    function it_can_get_all_notifications_for_a_user()
    {
        $user = $this->loginAsUser();
        $horse = $this->createHorse();
        $otherUser = $this->createUser(['email' => 'test@test.com']);

        DB::table('notifications')->insert([
            'sender_id' => $otherUser->id(),
            'receiver_id' => $user->id(),
            'data' => json_encode([
                'sender' => $otherUser->fullName(),
                'horse' => $horse->name(),
            ]),
            'type' => Notification::STATUS_LIKED,
            'read' => false,
            'link' => 'www.test.com',
        ]);

        $this->actingAs($user)
            ->get('/api/notifications')
            ->seeJsonEquals([
                'data' => [
                    [
                        'id' => 1,
                        'url' => 'http://localhost/notifications/1/show',
                        'type' => Notification::STATUS_LIKED,
                        'message' => 'John Doe has liked the status of test horse.',
                        'is_read' => false,
                        'icon' => 'fa-thumbs-o-up',
                        'formatted_date' => '2045 years ago',
                        'receiver' => $this->includedUser($user),
                        'sender' => $this->includedUser($otherUser),
                    ],
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

        DB::table('notifications')->insert([
            'sender_id' => $otherUser->id(),
            'receiver_id' => $user->id(),
            'data' => json_encode([
                'sender' => $otherUser->fullName(),
                'horse' => $horse->name(),
            ]),
            'type' => Notification::STATUS_LIKED,
            'read' => false,
            'link' => 'www.test.com',
        ]);

        $this->actingAs($user)
            ->get('/api/notifications/mark-as-read')
            ->seeJsonEquals([
                'data' => [
                    [
                        'id' => 1,
                        'url' => 'http://localhost/notifications/1/show',
                        'type' => Notification::STATUS_LIKED,
                        'message' => 'John Doe has liked the status of test horse.',
                        'is_read' => true,
                        'icon' => 'fa-thumbs-o-up',
                        'formatted_date' => '2045 years ago',
                        'receiver' => $this->includedUser($user),
                        'sender' => $this->includedUser($otherUser),
                    ],
                ],
            ]);
    }

    /** @test */
    function it_can_show_a_notification()
    {
        $user = $this->loginAsUser();
        $horse = $this->createHorse();
        $otherUser = $this->createUser(['email' => 'test@test.com']);

        DB::table('notifications')->insert([
            'sender_id' => $otherUser->id(),
            'receiver_id' => $user->id(),
            'data' => json_encode([
                'sender' => $otherUser->fullName(),
                'horse' => $horse->name(),
            ]),
            'type' => Notification::STATUS_LIKED,
            'read' => false,
            'link' => 'www.test.com',
        ]);

        $this->actingAs($user)
            ->get('/api/notifications/1')
            ->seeJsonEquals([
                'data' => [
                    'id' => 1,
                    'url' => 'http://localhost/notifications/1/show',
                    'type' => Notification::STATUS_LIKED,
                    'message' => 'John Doe has liked the status of test horse.',
                    'is_read' => false,
                    'icon' => 'fa-thumbs-o-up',
                    'formatted_date' => '2045 years ago',
                    'receiver' => $this->includedUser($user),
                    'sender' => $this->includedUser($otherUser),
                ],
            ]);
    }

    /** @test */
    function it_can_delete_a_notification()
    {
        $user = $this->loginAsUser();
        $horse = $this->createHorse();
        $otherUser = $this->createUser(['email' => 'test@test.com']);

        DB::table('notifications')->insert([
            'sender_id' => $otherUser->id(),
            'receiver_id' => $user->id(),
            'data' => json_encode([
                'sender' => $otherUser->fullName(),
                'horse' => $horse->name(),
            ]),
            'type' => Notification::STATUS_LIKED,
            'read' => false,
            'link' => 'www.test.com',
        ]);

        $this->actingAs($user)
            ->delete('api/notifications/1')
            ->assertResponseStatus(204);

        $this->missingFromDatabase('notifications', [
            'id' => 1,
        ]);
    }
}
