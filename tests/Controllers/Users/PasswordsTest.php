<?php
namespace Controllers\Users;

use EQM\Models\Users\EloquentUser;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PasswordsTest extends \TestCase
{
    use WithoutMiddleware;

    /** @test */
    function it_can_change_a_password()
    {
        $user = factory(EloquentUser::class)->create();

        $this->actingAs($user)
            ->post('settings/password', [
                'old_password' => 'password',
                'password' => 'newpassword',
                'password_confirmation' => 'newpassword',
            ])
            ->assertResponseStatus(302);
    }
}
