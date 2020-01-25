<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testAdminCanLogin()
    {
      $this->browse(function (Browser $browser) {
          $browser->visit('/login');
          $browser->clickLink('Admin');
          $browser->type('email', 'harbiso@ksau-hs.edu.sa'); // admin email
          $browser->type('password', '12345678');
          $browser->press('LOGIN');
          $browser->assertSee('ADMINISTRATOR');
      });
    }
}
