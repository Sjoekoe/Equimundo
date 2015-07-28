<?php
namespace Sessions;

use EQM\Events\UserRegistered;

class RegisterTest extends \TestCase
{
    /** @test */
    public function register()
    {
        $this->expectsEvents(UserRegistered::class);

        $this->visit('/register')
            ->type('JohnDoe', 'username')
            ->type('john@example.com', 'email')
            ->type('password', 'password')
            ->type('password', 'password_confirmation')
            ->press('Sign Up')
            ->seePageIs('/');

        $this->seeInDatabase('users', [
            'username' => 'JohnDoe',
            'email' => 'john@example.com'
        ]);
    }
}
