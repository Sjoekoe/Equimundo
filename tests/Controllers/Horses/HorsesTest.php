<?php
namespace Controllers\Horses;

use Carbon\Carbon;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\HorseTeams\EloquentHorseTeam;
use EQM\Models\Users\EloquentUser;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class HorsesTest extends \TestCase
{
    use WithoutMiddleware;

    /** @test */
    function it_can_create_a_horse()
    {
        $user = factory(EloquentUser::class)->create();

        $this->actingAs($user)
            ->post('/horses/create', [
                'name' => 'Foo horse',
                'gender' => 1,
                'color' => 1,
                'date_of_birth' => '08/06/1982',
                'height' => 5,
                'breed' => 1,
                'life_number' => '1234'
            ]);

        $this->assertRedirectedTo('/');
        $this->seeInDatabase('horses', [
                'id' => 1,
                'name' => 'Foo horse',
                'life_number' => '1234',
                'date_of_birth' => '1982-06-08 00:00:00',
                'height' => 5,
                'breed' => 1,
                'gender' => 1,
                'color' => 1
            ]);

        $this->seeInDatabase('horse_team', [
            'id' => 1,
            'user_id' => $user->id(),
            'horse_id' => 1,
            'type' => 1,
        ]);
    }

    /** @test */
    function it_can_edit_a_horse()
    {
        $now = Carbon::createFromDate(2000, 10, 5)->startOfDay();
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create();
        factory(EloquentHorseTeam::class)->create([
            'user_id' => $user->id,
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->put('/horses/edit/' . $horse->slug(), [
                'name' => 'Foo horse',
                'gender' => 1,
                'color' => 1,
                'date_of_birth' => $now->format('d/m/Y'),
                'height' => 5,
                'breed' => 1,
                'life_number' => '1234'
            ]);

        $this->assertRedirectedTo('/horses/edit/' . $horse->slug());
        $this->seeInDatabase('horses', [
            'id' => 1,
            'name' => 'Foo horse',
            'life_number' => '1234',
            'date_of_birth' => $now->toIso8601String(),
            'height' => 5,
            'breed' => 1,
            'gender' => 1,
            'color' => 1
        ]);
    }

    function it_can_delete_a_horse()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create();
        $horseTeam = factory(EloquentHorseTeam::class)->create([
            'user_id' => $user->id,
            'horse_id' => $horse->id()
        ]);

        $this->actingAs($user)
            ->get('/horses/' . $horse->slug() . '/delete');

        $this->assertRedirectedTo('/');
        $this->notSeeInDatabase('horse_team', [
            'id' => $horseTeam->id(),
        ]);
    }
}
