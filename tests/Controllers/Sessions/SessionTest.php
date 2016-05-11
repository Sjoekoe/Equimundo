<?php
namespace Controllers\Sessions;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class SessionTest extends \TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function login()
    {
        $user = $this->createUser([
            'email' => 'foo@bar.com',
        ]);

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('password', 'password')
            ->press('Login')
            ->seePageIs('/')
            ->dontSee('Welcome to Equimundo');
    }

    /** @test */
    public function it_can_not_login_when_the_user_is_not_activated()
    {
        $user = $this->createUser([
            'email' => 'foo@bar.com',
            'activated' => false,
        ]);

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('password', 'password')
            ->press('Login')
            ->seePageIs('/login')
            ->see('These credentials do not match our records, or your account has not been activated.');
    }

    /** @test */
    public function it_can_not_login_with_a_wrong_password()
    {
        $user = $this->createUser([
            'email' => 'foo@bar.com',
        ]);

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('foobar', 'password')
            ->press('Login')
            ->seePageIs('/login')
            ->see('These credentials do not match our records, or your account has not been activated.');
    }

    /** @test */
    function it_can_not_login_with_a_wrong_email_address()
    {
        $user = $this->createUser([
            'email' => 'foo@bar.com',
        ]);

        $this->visit('/login')
            ->type('wrong@email.com', 'email')
            ->type($user->password, 'password')
            ->press('Login')
            ->seePageIs('/login')
            ->see('These credentials do not match our records, or your account has not been activated.');
    }

    /** @test */
    public function logout()
    {
        $user = $this->createUser();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Logout')
            ->seePageIs('/home')
            ->see('The social network re-invented');
    }
}
