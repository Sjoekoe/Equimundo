<?php
namespace functional\Api;

use Carbon\Carbon;
use DB;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\Statuses\EloquentStatus;
use EQM\Models\Users\EloquentUser;

class StatusesTest extends \TestCase
{
    /** @test */
    function it_can_get_the_feed_for_a_user()
    {
        $now = Carbon::now();
        $user = factory(EloquentUser::class)->create([]);
        factory(EloquentHorse::class, 4)->create()->each(function($h) use ($user, $now) {
            factory(EloquentStatus::class, 1)->create([
                'horse_id' => $h->id(),
                'body' => 'Foo',
                'created_at' => $now,
            ]);
            DB::table('follows')->insert([
                'horse_id' => $h->id(),
                'user_id' => $user->id(),
            ]);
        });

        $this->get('/api/users/' . $user->id() . '/feed')
            ->seeJsonEquals([
                'data' => [
                    [
                        'id' => 1,
                        'body' => 'Foo',
                        'created_at' => $now->toIso8601String(),
                        'like_count' => 0,
                        'prefix' => 1,
                    ],
                    [
                        'id' => 2,
                        'body' => 'Foo',
                        'created_at' => $now->toIso8601String(),
                        'like_count' => 0,
                        'prefix' => 1,
                    ],
                    [
                        'id' => 3,
                        'body' => 'Foo',
                        'created_at' => $now->toIso8601String(),
                        'like_count' => 0,
                        'prefix' => 1,
                    ],
                    [
                        'id' => 4,
                        'body' => 'Foo',
                        'created_at' => $now->toIso8601String(),
                        'like_count' => 0,
                        'prefix' => 1,
                    ],
                ],
                'meta' => [
                    'pagination' => [
                        'count' => 4,
                        'current_page' => 1,
                        'links' => [],
                        'per_page' => 10,
                        'total' => 4,
                        'total_pages' => 1,
                    ],
                ],
            ]);
    }

    /** @test */
    function it_can_create_a_status()
    {
        $horse = factory(EloquentHorse::class)->create();

        $this->post('/api/statuses', [
            'horse_id' => $horse->id(),
            'body' => 'Foo',
        ])->seeJsonEquals([
            'data' => [
                'id' => 1,
                'body' => 'Foo',
                'created_at' => Carbon::now()->toIso8601String(),
                'like_count' => 0,
                'prefix' => null,
            ],
        ]);
    }

    /** @test */
    function it_can_show_a_status()
    {
        $horse = factory(EloquentHorse::class)->create();
        $status = factory(EloquentStatus::class)->create([
            'horse_id' => $horse->id(),
        ]);

        $this->get('/api/statuses/' . $status->id())
            ->seeJsonEquals([
                'data' => [
                    'id' => 1,
                    'body' => $status->body(),
                    'created_at' => $status->createdAt()->toIso8601String(),
                    'like_count' => 0,
                    'prefix' => 1,
                ],
            ]);
    }

    /** @test */
    function it_can_update_a_status()
    {
        $horse = factory(EloquentHorse::class)->create();
        $status = factory(EloquentStatus::class)->create([
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
                'prefix' => 1,
            ],
        ]);
    }

    /** @test */
    function it_can_delete_a_status()
    {
        $horse = factory(EloquentHorse::class)->create();
        $status = factory(EloquentStatus::class)->create([
            'horse_id' => $horse->id(),
        ]);

        $this->delete('/api/statuses/' . $status->id(), [])
            ->assertResponseStatus(204);

        $this->notSeeInDatabase('statuses', [
            'id' => $status->id(),
        ]);
    }
}
