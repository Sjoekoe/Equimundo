<?php 
$I = new FunctionalTester($scenario);
$I->am('a member');
$I->wantTo('post a status to one of my horses profile');

$I->signIn();
$I->amOnPage('/');

$I->selectOption('horse', Auth::user()->horses()->first()->id);
$I->postAStatus('my status');

$I->seeCurrentUrlEquals('');
$I->see('my status');

$I->seeRecord('statuses', [
    'horse_id' => Auth::user()->horses()->first()->id,
    'body' => 'my status'
]);