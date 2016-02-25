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
        $horse = factory(EloquentHorse::class)->create();
        $picture = factory(EloquentPicture::class)->create([
            'horse_id' => $horse->id(),
        ]);

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
                    'pictures' => [
                        'data' => [
                            [
                                'id' => $picture->id(),
                                'is_header_image' => $picture->headerImage(),
                                'is_image' => $picture->isImage(),
                                'is_movie' => $picture->isMovie(),
                                'is_profile_picture' => $picture->profilePicture(),
                                'mime' => $picture->mime(),
                                'path' => $picture->path(),
                            ],
                        ],
                    ],
                ],
            ]);
    }

    /** @test */
    function it_can_show_a_horse_with_statuses()
    {
        $horse = factory(EloquentHorse::class)->create();
        $picture = factory(EloquentPicture::class)->create([
            'horse_id' => $horse->id(),
        ]);
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
                    'pictures' => [
                        'data' => [
                            [
                                'id' => $picture->id(),
                                'is_header_image' => $picture->headerImage(),
                                'is_image' => $picture->isImage(),
                                'is_movie' => $picture->isMovie(),
                                'is_profile_picture' => $picture->profilePicture(),
                                'mime' => $picture->mime(),
                                'path' => $picture->path(),
                            ],
                        ],
                    ],
                    'statuses' => [
                        'data' => [
                            [
                                'id' => $status->id(),
                                'body' => $status->body(),
                                'created_at' => $status->createdAt()->toIso8601String(),
                                'prefix' => $status->prefix(),
                                'like_count' => 0,
                                'horse' => [
                                    'data' => [
                                        'id' => $horse->id(),
                                        'name' => $horse->name(),
                                        'life_number' => $horse->lifeNumber(),
                                        'breed' => $horse->breed,
                                        'height' => $horse->height(),
                                        'gender' => $horse->gender(),
                                        'date_of_birth' => $horse->dateOfBirth()->toIso8601String(),
                                        'color' => $horse->color(),
                                        'pictures' => [
                                            'data' => [
                                                [
                                                    'id' => $picture->id(),
                                                    'is_header_image' => $picture->headerImage(),
                                                    'is_image' => $picture->isImage(),
                                                    'is_movie' => $picture->isMovie(),
                                                    'is_profile_picture' => $picture->profilePicture(),
                                                    'mime' => $picture->mime(),
                                                    'path' => $picture->path(),
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
    }
}
