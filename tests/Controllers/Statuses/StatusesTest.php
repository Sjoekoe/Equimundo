<?php
namespace Controllers\Statuses;

use EQM\Models\Statuses\Status;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class StatusesTest extends \TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /** @test */
    function it_can_create_a_status()
    {
        $user = $this->createUser([
            'email' => 'foo@bar.com',
        ]);
        $horse = $this->createHorse();
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->post('/statuses/create', [
            'horse' => $horse->id(),
            'body' => 'some status',
        ]);

        $this->seeInDatabase(Status::TABLE, [
            'horse_id' => $horse->id(),
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
        $user = $this->createUser([
            'email' => 'foo@bar.com',
        ]);
        $horse = $this->createHorse();
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->put('/status/' . $status->id()  .'/edit', [
                'horse' => $horse->id(),
                'body' => 'Some status',
            ]);

        $this->seeInDatabase(Status::TABLE, [
            'id' => $status->id(),
            'body' => 'Some status'
        ]);
    }

    /** @test */
    function it_can_delete_a_status()
    {
        $user = $this->createUser([
            'email' => 'foo@bar.com',
        ]);
        $horse = $this->createHorse();
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->get('/status/' . $status->id() . '/delete');

        $this->notSeeInDatabase(Status::TABLE, [
            'id' => $status->id()
        ]);
    }
}
