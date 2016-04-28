<?php
namespace Controllers\Follows;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class FollowsTest extends \TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /** @test */
    function it_can_follow_and_unfollow_a_horse()
    {
        $user = $this->createUser();
        $horse = $this->createHorse();

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
