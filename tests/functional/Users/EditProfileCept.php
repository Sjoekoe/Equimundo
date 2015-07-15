<?php
$I = new FunctionalTester($scenario);
$I->am('a member');
$I->wantTo('edit my profile details');

$I->signIn();
$I->amOnPage('/edit-profile');

$I->fillField('First name:', 'John');
$I->fillField('Last name:', 'Doe');
$I->fillField('About:', 'lorem ipsum');
$I->selectOption('Gender:', 'M');
$I->fillField('date_of_birth', '08/06/1982');
$I->selectOption('country', 'BE');
$I->click('Save Profile');

$I->seeRecord('users', [
    'first_name' => 'John',
    'last_name' => 'Doe',
    'gender' => 'M',
    'date_of_birth' => '08/06/1982',
    'about' => 'lorem ipsum',
    'country' => 'BE'
]);
