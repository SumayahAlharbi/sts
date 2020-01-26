<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;


class EnduserTestCase extends DuskTestCase
{
     /**
     * A Dusk test example.
     *
     * @return void
     */
   
    public function testEnduserCanLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login');
            $browser->type('enduser@enduser.com', 'email');
            $browser->type('123123', 'password');
            $browser->press('Login');
            $browser->seePageIs('/');
        });
    }
}
