<?php 
$I = new FunctionalTester($scenario);
$I->am('guest');
$I->wantTo('sign up for an account');

$I->amOnPage('/');
$I->click('Register');
$I->seeCurrentUrlEquals('/register');

$I->fillField('Username:', 'JohnDoe');
$I->fillField('E-Mail Address:', 'john@example.com');
$I->fillField('Password:', 'password');
$I->fillField('Password Confirmation:', 'password');
$I->click('Sign Up');

$I->seeCurrentUrlEquals('');
$I->see('Welcome to HorseStories');

$I->seeRecord('users', [
    'username' => 'JohnDoe',
    'email' => 'john@example.com'
]);

$I->amLoggedAs(Auth::user());
