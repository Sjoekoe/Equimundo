<?php
namespace Codeception\Module;

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
        $I->fillField('email', $email);
        $I->fillField('password', 'password');
        $I->click('Login');
    }

    public function haveAnAccount($overrides = [])
    {
        return $this->have('HorseStories\Models\Users\User', $overrides);
    }

    public function haveAHorse($overrides = [])
    {
        return $this->have('HorseStories\Models\Horses\Horse', $overrides);
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
