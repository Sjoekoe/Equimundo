<?php
namespace Controllers\Sessions;

use Carbon\Carbon;
use EQM\Events\UserRegistered;
use EQM\Models\Users\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends \TestCase
{
    use DatabaseTransactions;

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
            ->type('08/02/1982', 'date_of_birth')
            ->check('terms')
            ->press('Register')
            ->seePageIs('/');

        $this->seeInDatabase(User::TABLE, [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com'
        ]);
    }

    /**
     * @test
     * @expectedException \Illuminate\Foundation\Validation\ValidationException
     */
    function it_can_not_register_when_you_are_younger_than_13()
    {
        $date = Carbon::now()->subYear(13)->format('d/m/Y');

        $this->visit('/register')
            ->type('John', 'first_name')
            ->type('Doe', 'last_name')
            ->type('john@example.com', 'email')
            ->type('password', 'password')
            ->type('password', 'password_confirmation')
            ->select('M', 'gender')
            ->type($date, 'date_of_birth')
            ->check('terms')
            ->press('Register')
            ->seePageIs('/register');

        $this->missingFromDatabase(User::TABLE, [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com'
        ]);
    }

    /**
     * @test
     * @expectedException  \Illuminate\Foundation\Validation\ValidationException
     */
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

        $this->missingFromDatabase(User::TABLE, [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com'
        ]);
    }

    /**
     * @test
     * @expectedException \Illuminate\Foundation\Validation\ValidationException
     */
    function it_can_not_register_when_an_email_has_already_been_taken()
    {
        $this->createUser([
            'email' => 'john@example.com',
        ]);

        $this->visit('/register')
            ->type('Foo', 'first_name')
            ->type('Bar', 'last_name')
            ->type('john@example.com', 'email')
            ->type('password', 'password')
            ->type('password', 'password_confirmation')
            ->check('terms')
            ->press('Register')
            ->seePageIs('/register');

        $this->missingFromDatabase(User::TABLE, [
            'first_name' => 'Foo',
            'last_name' => 'Bar',
            'email' => 'john@example.com'
        ]);
    }
}
