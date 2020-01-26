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
          $browser->type('email', env('TEST_ADMIN_ROLE_USER'));
          $browser->type('password', env('TEST_ADMIN_ROLE_PASSWORD'));
          $browser->press('LOGIN');
          $browser->assertSee('ADMINISTRATOR');
      });
    }
}
