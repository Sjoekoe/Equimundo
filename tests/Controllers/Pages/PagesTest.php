<?php
namespace Controllers\Pages;

use EQM\Models\Horses\EloquentHorse;
use EQM\Models\HorseTeams\EloquentHorseTeam;
use EQM\Models\Users\EloquentUser;

class PagesTest extends \TestCase
{
    /** @test */
    public function viewHomepage()
    {
        $this->visit('/')
            ->see('The social network for horses.');
    }

    /** @test */
    public function visitRegisterPage()
    {
        $this->visit('/')
            ->click('Create a new account')
            ->seePageIs('/register');
    }

    /** @test */
    public function visitLoginPage()
    {
        $this->visit('/')
            ->seePageIs('/login');
    }

    /** @test */
    public function visitDisciplinesPage()
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
}
