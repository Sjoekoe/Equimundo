<?php
namespace Codeception\Module;

use Laracasts\TestDummy\Factory as TestDummy;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class FunctionalHelper extends \Codeception\Module
{
    public function signIn()
    {
        $email = 'john@example.com';
        $password = bcrypt('password');
        $username = 'JohnDoe';

        $this->haveAnAccount(compact('email', 'password', 'username'));

        $I = $this->getModule('Laravel5');

        $I->amOnPage('/login');
        $I->fillField('email', $email);
        $I->fillField('password', 'password');
        $I->click('Login');
    }

    public function haveAnAccount($overrides = [])
    {
        TestDummy::create('HorseStories\Models\Users\User', $overrides);
    }
}
