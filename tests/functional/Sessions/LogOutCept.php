<?php
$I = new FunctionalTester($scenario);
$I->am('a member');
$I->wantTo('want to log out of the session');

$I->signIn();

$I->click('Sign Out');

$I->seeCurrentUrlEquals('');
$I->see('Register');
$I->dontSeeAuthentication();
