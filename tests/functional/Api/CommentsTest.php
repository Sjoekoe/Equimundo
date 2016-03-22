<?php
namespace functional\Api;

use Carbon\Carbon;
use EQM\Core\Testing\DefaultIncludes;
use EQM\Models\Comments\EloquentComment;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\Statuses\EloquentStatus;
use EQM\Models\Users\EloquentUser;

class CommentsTest extends \TestCase
{
    use DefaultIncludes;

    /** @test */
    function it_can_get_all_comments_for_a_status()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create();
        $status = factory(EloquentStatus::class)->create([
            'horse_id' => $horse->id(),
        ]);
        $comment = factory(EloquentComment::class)->create([
            'status_id' => $status->id(),
            'user_id' => $user->id(),
        ]);

        $this->get('/api/statuses/' . $status->id() . '/comments')
            ->seeJsonEquals([
                'data' => [
                    [
                        'id' => $comment->id(),
                        'body' => $comment->body(),
                        'like_count' => 0,
                        'can_delete_comment' => false,
                        'created_at' => $comment->createdAt()->toIso8601String(),
                        'user' => $this->includedUser($user),
                    ],
                ],
                'meta' => [
                    'pagination' => [
                        'count' => 1,
                        'current_page' => 1,
                        'links' => [],
                        'per_page' => 10,
                        'total' => 1,
                        'total_pages' => 1,
                    ],
                ],
            ]);
    }

    /** @test */
    function it_can_create_a_comment()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create();
        $status = factory(EloquentStatus::class)->create([
            'horse_id' => $horse->id(),
        ]);
        $now = new Carbon();

        $this->actingAs($user)
            ->post('/api/statuses/' . $status->id() . '/comments', [
            'body' => 'Foo',
        ])->seeJsonEquals([
                'data' => [
                    'id' => 1,
                    'body' => 'Foo',
                    'like_count' => 0,
                    'created_at' => $now->toIso8601String(),
                    'can_delete_comment' => true,
                    'user' => $this->includedUser($user),
                ],
            ]);
    }

    /** @test */
    function it_can_show_a_comment()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create();
        $status = factory(EloquentStatus::class)->create([
            'horse_id' => $horse->id(),
        ]);
        $comment = factory(EloquentComment::class)->create([
            'status_id' => $status->id(),
            'user_id' => $user->id(),
        ]);

        $this->get('/api/statuses/' . $status->id() . '/comments/' . $comment->id())
            ->seeJsonEquals([
                'data' => [
                    'id' => $comment->id(),
                    'body' => $comment->body(),
                    'like_count' => 0,
                    'created_at' => $comment->createdAt()->toIso8601String(),
                    'can_delete_comment' => false,
                    'user' => $this->includedUser($user),
                ],
            ]);
    }

    /** @test */
    public function it_can_show_a_comment_with_likes()
    {
        $user = $this->createUser();
        $horse = $this->createHorse();
        $status = factory(EloquentStatus::class)->create([
            'horse_id' => $horse->id(),
        ]);
        $comment = factory(EloquentComment::class)->create([
            'status_id' => $status->id(),
            'user_id' => $user->id(),
        ]);

        $this->app->make('db')->table('comment_likes')->insert([
            'comment_id' => $comment->id(),
            'user_id' => $user->id(),
        ]);

        $this->get('/api/statuses/' . $status->id() . '/comments/' . $comment->id())
            ->seeJsonEquals([
                'data' => [
                    'id' => $comment->id(),
                    'body' => $comment->body(),
                    'like_count' => 1,
                    'created_at' => $comment->createdAt()->toIso8601String(),
                    'can_delete_comment' => false,
                    'user' => $this->includedUser($user),
                    'likes' => [
                        'data' => [
                            [
                                'id' => $user->id(),
                                'first_name' => $user->firstName(),
                                'last_name' => $user->lastName(),
                                'email' => $user->email(),
                                'date_of_birth' => null,
                                'gender' => $user->gender(),
                                'country' => $user->country(),
                                'is_admin' => $user->isAdmin(),
                                'language' => $user->language(),
                                'slug' => $user->slug(),
                                'unread_notifications' => $user->unreadNotifications(),
                            ],
                        ],
                    ],
                ],
            ]);
    }

    /** @test */
    function it_can_update_a_comment()
    {
        $user = $this->createUser();
        $horse = $this->createHorse();
        $status = factory(EloquentStatus::class)->create([
            'horse_id' => $horse->id(),
        ]);
        $comment = factory(EloquentComment::class)->create([
            'status_id' => $status->id(),
            'user_id' => $user->id(),
        ]);

        $this->put('/api/statuses/' . $status->id() . '/comments/' . $comment->id(), [
            'body' => 'Foo',
        ])->seeJsonEquals([
                'data' => [
                    'id' => $comment->id(),
                    'body' => 'Foo',
                    'like_count' => 0,
                    'created_at' => $comment->createdAt()->toIso8601String(),
                    'can_delete_comment' => false,
                    'user' => $this->includedUser($user),
                ],
            ]);
    }

    /** @test */
    function it_can_delete_a_comment()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create();
        $status = factory(EloquentStatus::class)->create([
            'horse_id' => $horse->id(),
        ]);
        $comment = factory(EloquentComment::class)->create([
            'status_id' => $status->id(),
            'user_id' => $user->id(),
        ]);

        $this->delete('/api/statuses/' . $status->id() . '/comments/' . $comment->id(), [])
            ->assertResponseStatus(204);

        $this->notSeeInDatabase('comments', [
            'id' => $comment->id(),
        ]);
    }
}
