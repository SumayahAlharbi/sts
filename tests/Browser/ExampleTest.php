<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    use DatabaseMigrations {
        runDatabaseMigrations as baseRunDatabaseMigrations;
    }

    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function runDatabaseMigrations()
    {
        $this->baseRunDatabaseMigrations();
        $this->artisan('db:seed');
    }

    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Login')
                    ->screenshot('sts');
        });
    }

    public function testAdminCanLogin()
    {
      $this->browse(function (Browser $browser) {
          $browser->visit('/login');
          $browser->clickLink('Admin');
          $browser->type('email', env('TEST_ADMIN_ROLE_USER'));
          $browser->type('password', env('TEST_ADMIN_ROLE_PASSWORD'));
          $browser->press('LOGIN');
          $browser->assertSee('ADMINISTRATOR')
          ->screenshot('login');
      });
    }
}
