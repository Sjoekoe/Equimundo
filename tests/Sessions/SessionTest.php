<?php
namespace Sessions;

use EQM\Models\Users\EloquentUser;

class SessionTest extends \TestCase
{
    /** @test */
    public function login()
    {
        $user = factory(EloquentUser::class)->create([
            'email' => 'foo@bar.com',
        ]);

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('password', 'password')
            ->press('Sign In')
            ->seePageIs('/')
            ->dontSee('Welcome to Equimundo');
    }

    /** @test */
    public function logout()
    {
        $user = factory(EloquentUser::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Sign Out')
            ->seePageIs('/')
            ->see('Welcome to Equimundo');
    }
}
