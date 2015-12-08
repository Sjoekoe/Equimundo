<?php
namespace Palmares;

use Carbon\Carbon;
use EQM\Models\Disciplines\Discipline;
use EQM\Models\Events\EloquentEvent;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\HorseTeams\EloquentHorseTeam;
use EQM\Models\Palmares\EloquentPalmares;
use EQM\Models\Statuses\EloquentStatus;
use EQM\Models\Statuses\Status;
use EQM\Models\Users\EloquentUser;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PalmaresTest extends \TestCase
{
    use WithoutMiddleware;

    /** @test */
    function it_can_create_a_palmares()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create();
        factory(EloquentHorseTeam::class)->create([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);
        $date = Carbon::now()->startOfDay();

        $this->actingAs($user)
            ->post('/horses/' . $horse->slug() . '/palmares/create', [
                'event_name' => 'Foo event',
                'date' => $date->format('d/m/Y'),
                'discipline' => Discipline::DRESSAGE,
                'level' => 'Foo level',
                'ranking' => 1,
                'body' => 'Foo status'
            ])->assertResponseStatus(302);

        $this->seeInDatabase('palmares', [
            'id' => 1,
            'horse_id' => 1,
            'event_id' => 1,
            'ranking' => 1,
            'discipline' => Discipline::DRESSAGE,
            'date' => $date
        ]);

        $this->seeInDatabase('statuses', [
            'id' => 1,
            'body' => 'Foo status',
            'prefix' => Status::PREFIX_PALMARES,
        ]);
    }

    /** @test */
    function it_can_edit_a_palmares()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create();
        factory(EloquentHorseTeam::class)->create([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);
        $status = factory(EloquentStatus::class)->create([
            'horse_id' => $horse->id(),
        ]);
        $event = factory(EloquentEvent::class)->create([
            'creator_id' => $user->id(),
        ]);
        $palmares = factory(EloquentPalmares::class)->create([
            'horse_id' => $horse->id(),
            'status_id' => $status->id(),
            'event_id' => $event->id(),
        ]);

        $this->actingAs($user)
            ->put('/palmares/' . $palmares->id() . '/edit', [
                'event_name' => 'Foo event',
                'discipline' => Discipline::DRESSAGE,
                'level' => 'Foo level',
                'ranking' => 5,
                'body' => 'Foo status'
            ]);

        $this->assertResponseStatus(302);

        $this->seeInDatabase('palmares', [
            'id' => $palmares->id(),
            'horse_id' => 1,
            'event_id' => 1,
            'ranking' => 5,
            'level' => 'Foo level',
            'discipline' => Discipline::DRESSAGE,
        ]);
    }

    /** @test */
    function it_can_delete_a_palmares()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create();
        factory(EloquentHorseTeam::class)->create([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);
        $status = factory(EloquentStatus::class)->create([
            'horse_id' => $horse->id(),
        ]);
        $palmares = factory(EloquentPalmares::class)->create([
            'horse_id' => $horse->id(),
            'status_id' => $status->id(),
        ]);

        $this->actingAs($user)
            ->get('palmares/' . $palmares->id() . '/delete');

        $this->notSeeInDatabase('palmares', [
            'id' => 1,
        ]);
    }
}
