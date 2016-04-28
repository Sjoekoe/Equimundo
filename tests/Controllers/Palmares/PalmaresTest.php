<?php
namespace Controllers\Palmares;

use Carbon\Carbon;
use DB;
use EQM\Models\Disciplines\Discipline;
use EQM\Models\Events\Event;
use EQM\Models\Palmares\Palmares;
use EQM\Models\Statuses\Status;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PalmaresTest extends \TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /** @test */
    function it_can_create_a_palmares()
    {
        $user = $this->createUser();
        $horse = $this->createHorse();
        $this->createHorseTeam([
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

        $this->seeInDatabase(Palmares::TABLE, [
            'id' => DB::table(Palmares::TABLE)->first()->id,
            'horse_id' => $horse->id(),
            'event_id' => DB::table(Event::TABLE)->first()->id,
            'ranking' => 1,
            'discipline' => Discipline::DRESSAGE,
            'date' => $date
        ]);

        $this->seeInDatabase(Status::TABLE, [
            'id' => DB::table(Status::TABLE)->first()->id,
            'body' => 'Foo status',
            'prefix' => Status::PREFIX_PALMARES,
        ]);
    }

    /** @test */
    function it_can_edit_a_palmares()
    {
        $user = $this->createUser();
        $horse = $this->createHorse();
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);
        $event = $this->createEvent([
            'creator_id' => $user->id(),
        ]);
        $palmares = $this->createPalmares([
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
            'horse_id' => $horse->id(),
            'event_id' => $event->id(),
            'ranking' => 5,
            'level' => 'Foo level',
            'discipline' => Discipline::DRESSAGE,
        ]);
    }

    /** @test */
    function it_can_delete_a_palmares()
    {
        $user = $this->createUser();
        $horse = $this->createHorse();
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);
        $event = $this->createEvent([
            'creator_id' => $user->id(),
        ]);
        $palmares = $this->createPalmares([
            'horse_id' => $horse->id(),
            'status_id' => $status->id(),
            'event_id' => $event->id(),
        ]);

        $this->actingAs($user)
            ->get('palmares/' . $palmares->id() . '/delete');

        $this->notSeeInDatabase(Palmares::TABLE, [
            'id' => $palmares->id(),
        ]);
    }
}
