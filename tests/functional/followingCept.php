<?php 
$I = new FunctionalTester($scenario);
$I->am('user');
$I->wantTo('follow a horse');

$I->haveAHorse(['name' => 'foo']);
$I->signIn();

$I->amOnPage('/horses/foo');
$I->click('Follow foo');
$I->seeCurrentUrlEquals('/horses/foo');

$I->see('Unfollow foo');

$I->dontSee('Follow foo');
