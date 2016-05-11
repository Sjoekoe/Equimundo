<?php
namespace Controllers\Pages;

use EQM\Models\Horses\EloquentHorse;
use EQM\Models\HorseTeams\EloquentHorseTeam;
use EQM\Models\Users\EloquentUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PagesTest extends \TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function viewHomepage()
    {
        $this->visit('/')
            ->see('The social network re-invented');
    }

    /** @test */
    public function visitRegisterPage()
    {
        $this->visit('/home')
            ->click('Sign Up')
            ->seePageIs('/register');
    }

    /** @test */
    public function visitLoginPage()
    {
        $this->visit('/')
            ->seePageIs('/home');
    }
}
