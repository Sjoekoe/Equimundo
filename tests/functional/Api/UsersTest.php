<?php
namespace functional\Api;

class UsersTest extends \TestCase
{
    /** @test */
    function it_can_show_a_user()
    {
        $user = $this->createUser();

        $this->get('/api/users/' . $user->id())
            ->seeJsonEquals([
                'data' => [
                    'id' => $user->id(),
                    'first_name' => $user->firstName(),
                    'last_name' => $user->lastName(),
                    'email' => $user->email(),
                    'date_of_birth' => null,
                    'gender' => $user->gender(),
                    'country' => $user->country(),
                    'is_admin' => $user->isAdmin(),
                    'language' => $user->language(),
                ],
            ]);
    }
}
