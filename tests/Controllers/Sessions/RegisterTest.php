<?php
namespace Controllers\Sessions;

use EQM\Events\UserRegistered;

class RegisterTest extends \TestCase
{
    /** @test */
    public function register()
    {
        $this->expectsEvents(UserRegistered::class);

        $this->visit('/register')
            ->type('John', 'first_name')
            ->type('Doe', 'last_name')
            ->type('john@example.com', 'email')
            ->type('password', 'password')
            ->type('password', 'password_confirmation')
            ->press('Sign Up')
            ->seePageIs('/');

        $this->seeInDatabase('users', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com'
        ]);
    }
}
