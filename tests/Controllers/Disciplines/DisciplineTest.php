<?php
namespace Controllers\Disciplines;

use EQM\Models\Disciplines\Discipline;
use EQM\Models\Disciplines\EloquentDiscipline;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\HorseTeams\EloquentHorseTeam;
use EQM\Models\Users\EloquentUser;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DisciplineTest extends \TestCase
{
    /** @test */
    function visitDisciplinesPage()
    {
        $user = factory(EloquentUser::class)->create([]);
        $horse = factory(EloquentHorse::class)->create([]);
        factory(EloquentHorseTeam::class)->create([
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
        $user = factory(EloquentUser::class)->create([]);
        $horse = factory(EloquentHorse::class)->create([]);

        $this->setExpectedException(HttpException::class);

        $this->withoutMiddleware()
            ->actingAs($user)
            ->visit('/horses/' . $horse->slug() . '/disciplines')
            ->assertResponseStatus(403);
    }

    /** @test */
    function it_can_add_disciplines_for_a_horse()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create();
        factory(EloquentHorseTeam::class)->create([
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
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create();
        factory(EloquentHorseTeam::class)->create([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);
        factory(EloquentDiscipline::class)->create([
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
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create();
        factory(EloquentHorseTeam::class)->create([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);
        factory(EloquentDiscipline::class)->create([
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
