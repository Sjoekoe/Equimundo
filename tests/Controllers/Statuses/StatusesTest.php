<?php
namespace Controllers\Statuses;

use EQM\Models\Horses\EloquentHorse;
use EQM\Models\HorseTeams\EloquentHorseTeam;
use EQM\Models\Statuses\EloquentStatus;
use EQM\Models\Users\EloquentUser;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class StatusesTest extends \TestCase
{
    use WithoutMiddleware;

    /** @test */
    function it_can_create_a_status()
    {
        $user = factory(EloquentUser::class)->create([
            'email' => 'foo@bar.com',
        ]);
        $horse = factory(EloquentHorse::class)->create();
        factory(EloquentHorseTeam::class)->create([
            'user_id' => $user->id(),
            'horse_id' => $horse->id,
        ]);

        $this->actingAs($user)
            ->post('/statuses/create', [
            'horse' => $horse->id,
            'body' => 'some status',
        ]);

        $this->seeInDatabase('statuses', [
            'horse_id' => $horse->id,
            'body' => 'some status',
            'prefix' => null,
        ]);
    }

    /** @test */
    function it_can_show_a_status_when_not_logged_in() {
        $horse = $this->createHorse();
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        $this->visit('/status/' . $status->id() . '/show')
            ->assertResponseOk();
    }

    /** @test */
    function it_can_edit_a_status()
    {
        $user = factory(EloquentUser::class)->create([
            'email' => 'foo@bar.com',
        ]);
        $horse = factory(EloquentHorse::class)->create();
        factory(EloquentHorseTeam::class)->create([
            'user_id' => $user->id,
            'horse_id' => $horse->id,
        ]);
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->put('/status/' . $status->id()  .'/edit', [
                'horse' => $horse->id(),
                'body' => 'Some status',
            ]);

        $this->seeInDatabase('statuses', [
            'id' => $status->id(),
            'body' => 'Some status'
        ]);
    }

    /** @test */
    function it_can_delete_a_status()
    {
        $user = factory(EloquentUser::class)->create([
            'email' => 'foo@bar.com',
        ]);
        $horse = factory(EloquentHorse::class)->create();
        factory(EloquentHorseTeam::class)->create([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->get('/status/' . $status->id() . '/delete');

        $this->notSeeInDatabase('statuses', [
            'id' => $status->id()
        ]);
    }
}
