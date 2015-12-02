<?php
namespace Statuses;

use EQM\Models\Horses\EloquentHorse;
use EQM\Models\HorseTeams\EloquentHorseTeam;
use EQM\Models\Statuses\EloquentStatus;
use EQM\Models\Statuses\StatusRepository;
use EQM\Models\Users\EloquentUser;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class StatusesTest extends \TestCase
{
    use WithoutMiddleware;

    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    public function setup()
    {
        parent::setup();

        $this->statuses = app(StatusRepository::class);
    }

    public function tearDown()
    {
        unset($this->statuses);

        parent::tearDown();
    }

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
            'status' => 'some status',
        ]);

        $this->seeInDatabase('statuses', [
            'horse_id' => $horse->id,
            'body' => 'some status',
        ]);
    }

    // todo ask for advise
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
        $status = factory(EloquentStatus::class)->create([
            'horse_id' => $horse->id,
        ]);

        $this->actingAs($user)
            ->put('/status/' . $status->id  .'/edit', [
                'status' => 'Some status',
            ]);

        $status = $this->statuses->findById($status->id);

        $this->assertEquals('Some status', $status->body());
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
            'horse_id' => $horse->id,
        ]);
        $status = factory(EloquentStatus::class)->create([
            'horse_id' => $horse->id,
        ]);

        $this->actingAs($user)
            ->get('/status/' . $status->id . '/delete');

        $status = $this->statuses->findById($status->id);

        $this->assertNull($status);
    }
}
