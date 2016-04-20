<?php
namespace functional\Api;

use Carbon\Carbon;
use DB;

class StatusesTest extends \TestCase
{
    /** @test */
    function it_can_get_the_feed_for_a_user()
    {
        $user = $this->createUser();
        $horse = $this->createHorse();
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        DB::table('follows')->insert([
            'horse_id' => $horse->id(),
            'user_id' => $user->id(),
        ]);

        $this->get('/api/users/' . $user->id() . '/feed')
            ->seeJsonEquals([
                'data' => [
                    [
                        'id' => $status->id(),
                        'body' => $status->body(),
                        'created_at' => $status->createdAt()->toIso8601String(),
                        'like_count' => 0,
                        'prefix' => trans('statuses.prefixes.' . $status->prefix()),
                        'liked_by_user' => false,
                        'can_delete_status' => false,
                        'picture' => null,
                        'is_horse_status' => true,
                        'comments' => [
                            'data' => [],
                        ],
                        'poster' => [
                            'data' => [
                                'id' => $horse->id(),
                                'name' => $horse->name(),
                                'life_number' => $horse->lifeNumber(),
                                'breed' => $horse->breed,
                                'height' => $horse->height(),
                                'gender' => $horse->gender(),
                                'date_of_birth' => $horse->dateOfBirth()->toIso8601String(),
                                'color' => $horse->color(),
                                'slug' => $horse->slug(),
                                'profile_picture' =>  'http://localhost/images/eqm.png',
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
    function it_can_get_the_feed_for_a_horse()
    {
        $horse = $this->createHorse();
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        $this->get('/api/horses/' . $horse->id() . '/statuses')
            ->seeJsonEquals([
                'data' => [
                    [
                        'id' => $status->id(),
                        'body' => $status->body(),
                        'created_at' => $status->createdAt()->toIso8601String(),
                        'like_count' => 0,
                        'prefix' => trans('statuses.prefixes.' . $status->prefix()),
                        'liked_by_user' => false,
                        'can_delete_status' => false,
                        'picture' => null,
                        'is_horse_status' => true,
                        'comments' => [
                            'data' => [],
                        ],
                        'poster' => [
                            'data' => [
                                'id' => $horse->id(),
                                'name' => $horse->name(),
                                'life_number' => $horse->lifeNumber(),
                                'breed' => $horse->breed,
                                'height' => $horse->height(),
                                'gender' => $horse->gender(),
                                'date_of_birth' => $horse->dateOfBirth()->toIso8601String(),
                                'color' => $horse->color(),
                                'slug' => $horse->slug(),
                                'profile_picture' =>  'http://localhost/images/eqm.png',
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
    function it_can_create_a_status()
    {
        $horse = $this->createHorse();

        $this->post('/api/statuses', [
            'horse' => $horse->id(),
            'body' => 'Foo',
        ])->seeJsonEquals([
            'data' => [
                'id' => 1,
                'body' => 'Foo',
                'created_at' => Carbon::now()->toIso8601String(),
                'like_count' => 0,
                'prefix' => null,
                'liked_by_user' => false,
                'can_delete_status' => false,
                'is_horse_status' => true,
                'comments' => [
                    'data' => [],
                ],
                'picture' => null,
                'poster' => [
                    'data' => [
                        'id' => $horse->id(),
                        'name' => $horse->name(),
                        'life_number' => $horse->lifeNumber(),
                        'breed' => $horse->breed,
                        'height' => $horse->height(),
                        'gender' => $horse->gender(),
                        'date_of_birth' => $horse->dateOfBirth()->toIso8601String(),
                        'color' => $horse->color(),
                        'slug' => $horse->slug(),
                        'profile_picture' =>  'http://localhost/images/eqm.png',
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    function it_can_show_a_status()
    {
        $horse = $this->createHorse();
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        $this->get('/api/statuses/' . $status->id())
            ->seeJsonEquals([
                'data' => [
                    'id' => 1,
                    'body' => $status->body(),
                    'created_at' => $status->createdAt()->toIso8601String(),
                    'like_count' => 0,
                    'prefix' => trans('statuses.prefixes.' . $status->prefix()),
                    'liked_by_user' => false,
                    'can_delete_status' => false,
                    'is_horse_status' => true,
                    'comments' => [
                        'data' => [],
                    ],
                    'picture' => null,
                    'poster' => [
                        'data' => [
                            'id' => $horse->id(),
                            'name' => $horse->name(),
                            'life_number' => $horse->lifeNumber(),
                            'breed' => $horse->breed,
                            'height' => $horse->height(),
                            'gender' => $horse->gender(),
                            'date_of_birth' => $horse->dateOfBirth()->toIso8601String(),
                            'color' => $horse->color(),
                            'slug' => $horse->slug(),
                            'profile_picture' =>  'http://localhost/images/eqm.png',
                        ],
                    ],
                ],
            ]);
    }

    // todo find a way to authenticate
    function it_can_show_a_status_liked_by_a_user()
    {
        $user = $this->loginAsUser();
        $horse = $this->createHorse();
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        $this->app->make('db')->table('likes')->insert([
            'user_id' => $user->id(),
            'status_id' => $status->id(),
        ]);

        $this->actingAs($user)
            ->get('/api/statuses/' . $status->id())
            ->seeJsonEquals([
                'data' => [
                    'id' => 1,
                    'body' => $status->body(),
                    'created_at' => $status->createdAt()->toIso8601String(),
                    'like_count' => 0,
                    'prefix' => 1,
                    'liked_by_user' => true,
                    'is_horse_status' => true,
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
                            ],
                        ],
                    ],
                    'poster' => [
                        'data' => [
                            'id' => $horse->id(),
                            'name' => $horse->name(),
                            'life_number' => $horse->lifeNumber(),
                            'breed' => $horse->breed,
                            'height' => $horse->height(),
                            'gender' => $horse->gender(),
                            'date_of_birth' => $horse->dateOfBirth()->toIso8601String(),
                            'color' => $horse->color(),
                        ],
                    ],
                ],
            ]);
    }

    /** @test */
    function it_can_show_a_status_with_the_likers()
    {
        $user = $this->createUser();
        $horse = $this->createHorse();
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        $this->app->make('db')->table('likes')->insert([
            'status_id' => $status->id(),
            'user_id' => $user->id(),
        ]);

        $this->get('/api/statuses/' . $status->id())
            ->seeJsonEquals([
                'data' => [
                    'id' => 1,
                    'body' => $status->body(),
                    'created_at' => $status->createdAt()->toIso8601String(),
                    'like_count' => 1,
                    'prefix' => trans('statuses.prefixes.' . $status->prefix()),
                    'liked_by_user' => false,
                    'can_delete_status' => false,
                    'is_horse_status' => true,
                    'comments' => [
                        'data' => [],
                    ],
                    'picture' => null,
                    'poster' => [
                        'data' => [
                            'id' => $horse->id(),
                            'name' => $horse->name(),
                            'life_number' => $horse->lifeNumber(),
                            'breed' => $horse->breed,
                            'height' => $horse->height(),
                            'gender' => $horse->gender(),
                            'date_of_birth' => $horse->dateOfBirth()->toIso8601String(),
                            'color' => $horse->color(),
                            'slug' => $horse->slug(),
                            'profile_picture' =>  'http://localhost/images/eqm.png',
                        ],
                    ],
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
                                'unread_notifications' => 0,
                            ],
                        ],
                    ],
                ],
            ]);
    }

    /** @test */
    function it_can_update_a_status()
    {
        $horse = $this->createHorse();
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        $this->put('/api/statuses/' . $status->id(), [
            'body' => 'Foo',
        ])->seeJsonEquals([
            'data' => [
                'id' => 1,
                'body' => 'Foo',
                'created_at' => $status->createdAt()->toIso8601String(),
                'like_count' => 0,
                'prefix' => trans('statuses.prefixes.' . $status->prefix()),
                'liked_by_user' => false,
                'can_delete_status' => false,
                'is_horse_status' => true,
                'comments' => [
                    'data' => [],
                ],
                'picture' => null,
                'poster' => [
                    'data' => [
                        'id' => $horse->id(),
                        'name' => $horse->name(),
                        'life_number' => $horse->lifeNumber(),
                        'breed' => $horse->breed,
                        'height' => $horse->height(),
                        'gender' => $horse->gender(),
                        'date_of_birth' => $horse->dateOfBirth()->toIso8601String(),
                        'color' => $horse->color(),
                        'slug' => $horse->slug(),
                        'profile_picture' =>  'http://localhost/images/eqm.png',
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    function it_can_delete_a_status()
    {
        $horse = $this->createHorse();
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        $this->delete('/api/statuses/' . $status->id(), [])
            ->assertResponseStatus(204);

        $this->notSeeInDatabase('statuses', [
            'id' => $status->id(),
        ]);
    }
}
