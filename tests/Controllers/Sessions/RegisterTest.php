<?php
namespace Controllers\Sessions;

use EQM\Events\UserRegistered;
use EQM\Models\Users\EloquentUser;

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
            ->select('M', 'gender')
            ->type('08/02/198', 'date_of_birth')
            ->check('terms')
            ->press('Register')
            ->seePageIs('/');

        $this->seeInDatabase('users', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com'
        ]);
    }

    /** @test */
    function it_cannot_register_when_the_terms_are_not_checked()
    {
        $this->visit('/register')
            ->type('John', 'first_name')
            ->type('Doe', 'last_name')
            ->type('john@example.com', 'email')
            ->type('password', 'password')
            ->type('password', 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register');

        $this->missingFromDatabase('users', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com'
        ]);
    }

    /** @test */
    function it_can_not_register_when_an_email_has_already_been_taken()
    {
        factory(EloquentUser::class)->create([
            'email' => 'john@example.com',
        ]);

        $this->visit('/register')
            ->type('John', 'first_name')
            ->type('Doe', 'last_name')
            ->type('john@example.com', 'email')
            ->type('password', 'password')
            ->type('password', 'password_confirmation')
            ->check('terms')
            ->press('Register')
            ->seePageIs('/register');

        $this->missingFromDatabase('users', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com'
        ]);
    }
}
