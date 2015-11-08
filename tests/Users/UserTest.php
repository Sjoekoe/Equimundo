<?php
namespace Users;

use EQM\Models\Users\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends \TestCase
{
    use WithoutMiddleware;

    /** @test */
    function add_user_details() {
        $user = factory(User::class)->create([
            'activated' => true,
        ]);

        $this->actingAs($user)
            ->post('/edit-profile', [
                'first_name' => 'Foo',
                'last_name' => 'Bar',
                'gender' => 'M',
                'country' => 'BE',
                'about' => 'test info',
                'date_of_birth' => '08/06/1982',
            ]);

        $this->assertRedirectedTo('/edit-profile');

        $this->seeInDatabase('users', [
            'id' => 1,
            'first_name' => 'Foo',
            'last_name' => 'Bar',
            'gender' => 'M',
            'date_of_birth' => '1982-06-08 00:00:0000',
            'about' => 'test info',
            'country' => 'BE'
        ]);
    }
}
