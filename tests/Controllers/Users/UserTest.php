<?php
namespace Controllers\Users;

use EQM\Models\Horses\Horse;
use EQM\Models\HorseTeams\HorseTeam;
use EQM\Models\Users\EloquentUser;
use EQM\Models\Users\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends \TestCase
{
    use WithoutMiddleware;

    /** @test */
    function add_user_details() {
        $user = factory(EloquentUser::class)->create([
            'activated' => true,
        ]);

        $this->actingAs($user)
            ->post('/edit-profile', [
                'first_name' => 'Foo',
                'last_name' => 'Bar',
                'gender' => 'M',
                'country' => 'BE',
                'about' => 'test info',
                'date_of_birth' => '08/06/1982',
            ]);

        $this->assertRedirectedTo('/edit-profile');

        $this->seeInDatabase(User::TABLE, [
            'id' => 1,
            'first_name' => 'Foo',
            'last_name' => 'Bar',
            'gender' => 'M',
            'date_of_birth' => '1982-06-08 00:00:0000',
            'about' => 'test info',
            'country' => 'BE'
        ]);
    }

    /** @test */
    function it_can_delete_a_user() {
        $user = $this->loginAsUser();

        $this->get('/users/delete');

        $this->assertResponseStatus(302);

        $this->notSeeInDatabase(User::TABLE, [
            'id' => $user->id(),
        ]);
    }

    /** @test */
    function it_removes_horse_teams_but_the_horse_stays_intact_when_deleting_an_account()
    {
        $user = $this->loginAsUser();
        $horse = $this->createHorse();
        $horseTeam = $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
            'type' => HorseTeam::OWNER,
        ]);

        $this->get('/users/delete');

        $this->assertResponseStatus(302);

        $this->notSeeInDatabase(User::TABLE, [
            'id' => $user->id(),
        ]);

        $this->notSeeInDatabase(HorseTeam::TABLE, [
            'id' => $horseTeam->id(),
        ]);

        $this->seeInDatabase(Horse::TABLE, [
            'id' => $horse->id(),
        ]);
    }
}
