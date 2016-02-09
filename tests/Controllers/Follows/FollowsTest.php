<?php
namespace Controllers\Follows;

use EQM\Models\Horses\EloquentHorse;
use EQM\Models\Users\EloquentUser;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class FollowsTest extends \TestCase
{
    use WithoutMiddleware;

    /** @test */
    function it_can_follow_and_unfollow_a_horse()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create();

        $this->actingAs($user)
            ->post('/follows/' . $horse->id());

        $this->seeInDatabase('follows', [
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->delete('/follows/' . $horse->id());

        $this->missingFromDatabase('follows', [
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);
    }
}
