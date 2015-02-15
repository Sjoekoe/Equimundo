<?php 
$I = new FunctionalTester($scenario);
$I->am('a member');
$I->wantTo('log in to my account');

$I->signIn();

$I->seeCurrentUrlEquals('');
$I->see('Welcome back JohnDoe');
