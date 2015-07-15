<?php
namespace Sessions;

use HorseStories\Models\Settings\Setting;
use HorseStories\Models\Users\User;
use TestCase;

class SessionTest extends TestCase
{
    /** @test */
    public function login()
    {
        $user = factory(User::class)->create([
            'email' => 'foo@bar.com',
        ]);

        factory(Setting::class)->create([
            'user_id' => $user->id
        ]);

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('password', 'password')
            ->press('Sign In')
            ->onPage('/');
    }
}
