<?php
namespace Controllers\Users;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PasswordsTest extends \TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /** @test */
    function it_can_change_a_password()
    {
        $user = $this->createUser();

        $this->actingAs($user)
            ->post('settings/password', [
                'old_password' => 'password',
                'password' => 'newpassword',
                'password_confirmation' => 'newpassword',
            ])
            ->assertResponseStatus(302);
    }
}
