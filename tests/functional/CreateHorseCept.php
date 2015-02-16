<?php 
$I = new FunctionalTester($scenario);
$I->am('a member');
$I->wantTo('create a new horse');

$I->signIn();

$I->amOnPage('/');
$I->click('+');

$I->fillField('name', 'Florien');
$I->selectOption('gender', 'Mare');
$I->fillField('breed', 'Westphalian');
$I->fillField('height', '1m70');
$I->selectOption('color', 'Bay');
$I->fillField('date_of_birth', '18/02/1997');
$I->fillField('life_number', 'lorem341412056297');
$I->click('Create Horse');

$I->seeCurrentUrlEquals('/horses/index');
$I->see('Florien was successfully created.');

$I->seeRecord('horses', [
    'name' => 'Florien',
    'user_id' => Auth::user()->id,
    'gender' => 5,
    'breed' => 'Westphalian',
    'height' => '1m70',
    'color' => 1,
    'date_of_birth' => '18/02/1997',
    'life_number' => 'lorem341412056297',
]);