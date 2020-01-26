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
                  ->assertSee('Ticket has been created');
                  //->screenshot('create_ticket');
      });
    }

    /* View the last added ticket */
    public function testAdminViewTicket()
    {
      $this->browse(function (Browser $browser) {
          $browser->visit('/ticket');
          $browser->press('table > tbody > tr:nth-child(1) > td.footable-first-column > span.footable-toggle');
          $browser->press('.btn-success')
                  ->assertSee('Ticket Content');
                  //->screenshot('view_ticket');
      });
    }

    /* Edit the last added ticket */
    public function testAdminEditTicket()
    {
      $this->browse(function (Browser $browser) {
          $browser->visit('/ticket');
          $browser->press('table > tbody > tr:nth-child(1) > td.footable-first-column > span.footable-toggle');
          $browser->press('.btn-warning');
          $browser->type('ticket_title', 'update ticket' . Carbon::now()->toDateTimeString());
          $browser->script("CKEDITOR.instances['editor'].setData('Updated Data');");
          $browser->select('group_id','2');
          $browser->select('category_id', '2');
          $browser->select('location_id', '2');
          $browser->press('Update')
                  ->assertSee('Ticket has been updated');
                  //->screenshot('update_ticket');
      });
    }

}
