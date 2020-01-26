<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;

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

    public function testAdminCreateTicket()
    {
      $this->browse(function (Browser $browser) {
          $browser->visit('/ticket');
          $browser->waitFor('.create-ticket-button');
          $browser->clickLink('Create Ticket');
          $browser->visit('/ticket/create');
          $browser->type('ticket_title', 'test ticket ' . Carbon::now()->toDateTimeString());
          $browser->script("CKEDITOR.instances['contentEditor'].setData('Test Data');");
          $browser->pause(3000);
          $browser->select('region','1');
          $browser->waitFor('.group');
          $browser->select('group_id','1');
          $browser->waitFor('#locationDiv');
          $browser->select('location_id', '1');
          $browser->waitFor('#categoryDiv');
          $browser->select('category_id', '1');
          $browser->press('Create')
                  ->assertSee('Ticket has been created')
                  ->screenshot('create_ticket'); // not needed
      });
    }

}
