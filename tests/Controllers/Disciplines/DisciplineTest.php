<?php
namespace Controllers\Disciplines;

use EQM\Models\Disciplines\Discipline;
use EQM\Models\Disciplines\EloquentDiscipline;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DisciplineTest extends \TestCase
{
    use DatabaseTransactions;

    /** @test */
    function visitDisciplinesPage()
    {
        $user = $this->createUser();
        $horse = $this->createHorse();
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);

        $this->withoutMiddleware()
            ->actingAs($user)
            ->visit('/horses/' . $horse->slug() . '/disciplines')
            ->assertResponseStatus(200);
    }

    /** @test */
    function it_can_not_access_the_disciplines_of_a_horse_that_doesnt_belong_to_you()
    {
        $user = $this->createUser();
        $horse = $this->createHorse();

        $this->setExpectedException(AuthorizationException::class);

        $this->withoutMiddleware()
            ->actingAs($user)
            ->visit('/horses/' . $horse->slug() . '/disciplines')
            ->assertResponseStatus(403);
    }

    /** @test */
    function it_can_add_disciplines_for_a_horse()
    {
        $user = $this->createUser();
        $horse = $this->createHorse();
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);

        $this->withoutMiddleware()
            ->actingAs($user)
            ->post('horses/' . $horse->slug() . '/disciplines', [
                'disciplines' => [
                    Discipline::BANEI,
                    Discipline::CALF_ROPING,
                    Discipline::DRESSAGE,
                ],
            ])->assertResponseStatus(302);

        $this->seeInDatabase('disciplines', [
            'horse_id' => $horse->id(),
            'discipline' => Discipline::CALF_ROPING,
        ]);

        $this->seeInDatabase('disciplines', [
            'horse_id' => $horse->id(),
            'discipline' => Discipline::BANEI,
        ]);

        $this->seeInDatabase('disciplines', [
            'horse_id' => $horse->id(),
            'discipline' => Discipline::DRESSAGE,
        ]);
    }

    /** @test */
    function it_removes_disciplines_when_they_are_not_selected_anymore()
    {
        $user = $this->createUser();
        $horse = $this->createHorse();
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);
        $this->createDiscipline([
            'horse_id' => $horse->id(),
            'discipline' => Discipline::SHOW_JUMPING,
        ]);

        $this->withoutMiddleware()
            ->actingAs($user)
            ->post('horses/' . $horse->slug() . '/disciplines', [
                'disciplines' => [
                    Discipline::BANEI,
                    Discipline::CALF_ROPING,
                    Discipline::DRESSAGE,
                ],
            ])->assertResponseStatus(302);

        $this->seeInDatabase('disciplines', [
            'horse_id' => $horse->id(),
            'discipline' => Discipline::CALF_ROPING,
        ]);

        $this->seeInDatabase('disciplines', [
            'horse_id' => $horse->id(),
            'discipline' => Discipline::BANEI,
        ]);

        $this->seeInDatabase('disciplines', [
            'horse_id' => $horse->id(),
            'discipline' => Discipline::DRESSAGE,
        ]);

        $this->missingFromDatabase('disciplines', [
            'horse_id' => $horse->id(),
            'discipline' => Discipline::SHOW_JUMPING,
        ]);
    }

    /** @test */
    function it_does_not_duplicate_disciplines()
    {
        $user = $this->createUser();
        $horse = $this->createHorse();
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);
        $this->createDiscipline([
            'horse_id' => $horse->id(),
            'discipline' => Discipline::SHOW_JUMPING,
        ]);

        $this->withoutMiddleware()
            ->actingAs($user)
            ->post('horses/' . $horse->slug() . '/disciplines', [
                'disciplines' => [
                    Discipline::SHOW_JUMPING,
                    Discipline::CALF_ROPING,
                    Discipline::DRESSAGE,
                ],
            ])->assertResponseStatus(302);

        $this->seeInDatabase('disciplines', [
            'horse_id' => $horse->id(),
            'discipline' => Discipline::SHOW_JUMPING,
        ]);

        $this->seeInDatabase('disciplines', [
            'horse_id' => $horse->id(),
            'discipline' => Discipline::CALF_ROPING,
        ]);

        $this->seeInDatabase('disciplines', [
            'horse_id' => $horse->id(),
            'discipline' => Discipline::DRESSAGE,
        ]);

        $count = EloquentDiscipline::where('horse_id', $horse->id())->get();

        $this->assertEquals(3, count($count));
    }
}
