<?php 
$I = new FunctionalTester($scenario);
$I->am('guest');
$I->wantTo('sign up for an account');

$I->amInPath('/');
$I->click('Register');
$I->seeCurrentUrlEquals('/register');

$I->fillField('Username:', 'JohnDoe');
$I->fillField('Email:', 'john@example.com');
$I->fillField('Password:', 'demo');
$I->fillField('Password Confirmation:', 'demo');
$I->click('register');

$I->seeCurrentUrlEquals('/');