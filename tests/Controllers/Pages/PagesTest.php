<?php
namespace Controllers\Pages;

class PagesTest extends \TestCase
{
    /** @test */
    public function viewHomepage()
    {
        $this->visit('/')
            ->see('The social network for horses.');
    }

    /** @test */
    public function visitRegisterPage()
    {
        $this->visit('/')
            ->click('Create a new account')
            ->seePageIs('/register');
    }

    /** @test */
    public function visitLoginPage()
    {
        $this->visit('/')
            ->seePageIs('/login');
    }
}
