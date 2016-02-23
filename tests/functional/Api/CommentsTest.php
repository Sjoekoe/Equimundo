<?php
namespace functional\Api;

use EQM\Models\Comments\EloquentComment;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\Statuses\EloquentStatus;
use EQM\Models\Users\EloquentUser;

class CommentsTest extends \TestCase
{
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
                        'user' => [
                            'data' => [
                                'id' => $user->id(),
                                'first_name' => $user->firstName(),
                                'last_name' => $user->lastName(),
                                'email' => $user->email(),
                                'date_of_birth' => null,
                                'gender' => $user->gender(),
                                'country' => $user->country(),
                                'is_admin' => $user->isAdmin(),
                                'language' => $user->language(),
                            ],
                        ],
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

        $this->actingAs($user)
            ->post('/api/statuses/' . $status->id() . '/comments', [
            'body' => 'Foo',
        ])->seeJsonEquals([
                'data' => [
                    'id' => 1,
                    'body' => 'Foo',
                    'user' => [
                        'data' => [
                            'id' => $user->id(),
                            'first_name' => $user->firstName(),
                            'last_name' => $user->lastName(),
                            'email' => $user->email(),
                            'date_of_birth' => null,
                            'gender' => $user->gender(),
                            'country' => $user->country(),
                            'is_admin' => $user->isAdmin(),
                            'language' => $user->language(),
                        ],
                    ],
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
                    'user' => [
                        'data' => [
                            'id' => $user->id(),
                            'first_name' => $user->firstName(),
                            'last_name' => $user->lastName(),
                            'email' => $user->email(),
                            'date_of_birth' => null,
                            'gender' => $user->gender(),
                            'country' => $user->country(),
                            'is_admin' => $user->isAdmin(),
                            'language' => $user->language(),
                        ],
                    ],
                ],
            ]);
    }

    /** @test */
    function it_can_update_a_comment()
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

        $this->put('/api/statuses/' . $status->id() . '/comments/' . $comment->id(), [
            'body' => 'Foo',
        ])->seeJsonEquals([
                'data' => [
                    'id' => $comment->id(),
                    'body' => 'Foo',
                    'user' => [
                        'data' => [
                            'id' => $user->id(),
                            'first_name' => $user->firstName(),
                            'last_name' => $user->lastName(),
                            'email' => $user->email(),
                            'date_of_birth' => null,
                            'gender' => $user->gender(),
                            'country' => $user->country(),
                            'is_admin' => $user->isAdmin(),
                            'language' => $user->language(),
                        ],
                    ],
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
