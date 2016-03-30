<?php
namespace functional\Api;

use EQM\Models\Horses\EloquentHorse;
use EQM\Models\Pictures\EloquentPicture;
use EQM\Models\Statuses\EloquentStatus;

class HorsesTest extends \TestCase
{
    /** @test */
    public function it_can_show_a_horse()
    {
        $horse = $this->createHorse();

        $this->get('api/horses/' . $horse->id())
            ->seeJsonEquals([
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
            ]);
    }

    /** @test */
    function it_can_show_a_horse_with_statuses()
    {
        $horse = $this->createHorse();
        $status = factory(EloquentStatus::class)->create([
            'horse_id' => $horse->id(),
        ]);

        $this->get('api/horses/' . $horse->id(). '?include=statuses')
            ->seeJsonEquals([
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
                    'statuses' => [
                        'data' => [
                            [
                                'id' => $status->id(),
                                'body' => $status->body(),
                                'created_at' => $status->createdAt()->toIso8601String(),
                                'prefix' => trans('statuses.prefixes.' . $status->prefix()),
                                'like_count' => 0,
                                'liked_by_user' => false,
                                'can_delete_status' => false,
                                'comments' => [
                                    'data' => []
                                ],
                                'horseRelation' => [
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
                                'picture' => null,
                            ],
                        ],
                    ],
                ],
            ]);
    }
}
