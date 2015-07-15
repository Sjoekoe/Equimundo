<?php
$I = new FunctionalTester($scenario);
$I->am('guest');
$I->wantTo('sign up for an account');

$I->amOnPage('/');
$I->click('Sign Up');
$I->seeCurrentUrlEquals('/register');

$I->fillField('Username:', 'foo');
$I->fillField('Email:', 'foo@bar.com');
$I->fillField('Password:', 'password');
$I->fillField('Confirm Password:', 'password');
$I->click('Sign Up');

$I->seeCurrentUrlEquals('');

$I->seeRecord('users', [
    'username' => 'foo',
    'email' => 'foo@bar.com'
]);

$I->amLoggedAs(Auth::user());
