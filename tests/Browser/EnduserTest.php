<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;


class EnduserTest extends DuskTestCase
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
            $browser->clickLink('Admin');
            $browser->type('email', 'enduser@enduser.com');
            $browser->type('password', '123123');
            // $browser->pause(3000);
            $browser->press('LOGIN');
            // $browser->pause(3000);
            $browser->assertPathIs('/');
        });
    }
}
