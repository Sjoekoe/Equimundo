<?php
namespace Codeception\Module;

use HorseStories\Models\Horses\Horse;
use HorseStories\Models\Users\User;
use Laracasts\TestDummy\Factory as TestDummy;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class FunctionalHelper extends \Codeception\Module
{
    public function signIn()
    {
        $id = 1;
        $email = 'john@example.com';
        $password = bcrypt('password');
        $username = 'JohnDoe';

        $user = $this->haveAnAccount(compact('id', 'email', 'password', 'username'));
        $this->haveAHorse(['id' => 1, 'user_id' => $user->id]);

        $I = $this->getModule('Laravel5');

        $I->amOnPage('/login');
        $I->fillField('Email:', $email);
        $I->fillField('Password:', 'password');
        $I->click('Sign In');
    }

    public function haveAnAccount($overrides = [])
    {
        return $this->have(User::class, $overrides);
    }

    public function haveAHorse($overrides = [])
    {
        return $this->have(Horse::class, $overrides);
    }

    public function postAStatus($body)
    {
        $I = $this->getModule('Laravel5');

        $I->fillfield('status', $body);
        $I->click('Post Status');
    }

    public function have($model, $overrides = [])
    {
        return TestDummy::create($model, $overrides);
    }
}
