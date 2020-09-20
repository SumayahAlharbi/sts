<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;

class AdminTest  extends DuskTestCase
{
  use DatabaseMigrations;

  /**
   * Define hooks to migrate the database before and after each test.
   *
   * @return void
   */
   protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }

    /* Admin Login */
    public function testAdminCanLogin()
    {
      $this->browse(function (Browser $browser) {
          $browser->visit('/login');
          $browser->clickLink('Admin');
          $browser->type('email', 'admin@admin.com');
          $browser->type('password', '123123');
          $browser->press('LOGIN');
          $browser->assertSee('ADMINISTRATOR');
      });
    }

    /* Create New ticket */
    public function testAdminCreateTicket()
    {
      $this->browse(function (Browser $browser) {
          $browser->visit('/ticket');
          $browser->waitFor('.create-ticket-button');
          $browser->clickLink('Create Ticket');
          //$browser->visit('/ticket/create'); // Duplicate with above link
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

    /* View the first ticket in tickets index page */
    public function testAdminViewTicket()
    {
      $this->browse(function (Browser $browser) {
          $browser->visit('/ticket');
          $browser->press('table > tbody > tr:nth-child(1) > td.footable-first-column > span.footable-toggle');
          $browser->press('div.footable-row-detail-value > form > a.btn.btn-success')
                  ->assertSee('Ticket Content');
                  //->screenshot('view_ticket');
      });
    }

    /* Edit the first ticket in tickets index page */
    public function testAdminEditTicket()
    {
      $this->browse(function (Browser $browser) {
          $browser->visit('/ticket');
          $browser->press('table > tbody > tr:nth-child(1) > td.footable-first-column > span.footable-toggle');
          $browser->press('div.footable-row-detail-value > form > a.btn.btn-warning');
          $browser->type('ticket_title', 'update ticket' . Carbon::now()->toDateTimeString());
          $browser->script("CKEDITOR.instances['editor'].setData('Updated Data');");
          $browser->select('group_id','2');
          $browser->pause(3000);
          $browser->select('category_id', '3');
          $browser->select('location_id', '3');
          $browser->press('Update')
                  ->assertSee('Ticket has been updated');
                  //->screenshot('update_ticket');
      });
    }

    /* Assign the first Ticket to an Agent */
    public function testAdminAssignTicketToAgent()
    {
      $this->browse(function (Browser $browser) {
          $browser->visit('/ticket');
          $browser->press('table > tbody > tr:nth-child(1) > td.footable-first-column > span.footable-toggle');
          $browser->pause(3000);
          $browser->click('div.footable-row-detail-value > form > a.btn.btn-success');
          $browser->click('button.btn.btn-outline-info'); // assign button
          $browser->waitFor('#exampleModalLabel1');
          $browser->select('user_id','2') // change agent id here
                  ->click('#assignModal > div > div > div.modal-footer > button.btn.btn-primary')
                  ->assertSeeIn('div.card-footer.text-muted', 'agent'); // change corresponding name here
                  //->screenshot('assign_ticket');

      });
    }

    /* Unassign the first Ticket from Agent */
    public function testAdminUnassignAgentFromTicket()
    {
      $this->browse(function (Browser $browser) {
          $browser->visit('/ticket');
          $browser->press('table > tbody > tr:nth-child(1) > td.footable-first-column > span.footable-toggle');
          $browser->click('div.footable-row-detail-value > form > a.btn.btn-success');
          $browser->click('button.btn.btn-outline-info'); // assign button
          $browser->waitFor('#exampleModalLabel1');
          $browser->assertSeeIn('#assignModal > div > div > div.modal-body > form', 'agent'); // change agent name here
          $browser->click('#assignModal > div > div > div.modal-body > form > div:nth-child(4) > a') // unassign the first assigned agent (most left)
                  ->assertDialogOpened('Do you really want to unassign agent ?') // change agent name here
                  ->acceptDialog();
          $browser->assertDontSee('#assignModal > div > div > div.modal-body > form', 'agent'); // change agent name here
                  //->screenshot('unassign_ticket');

      });
    }

    /* Delete the first ticket in tickets index page */
    public function testAdminDeleteTicket()
    {
      $this->browse(function (Browser $browser) {
          $browser->visit('/ticket');
          $browser->press('table > tbody > tr:nth-child(1) > td.footable-first-column > span.footable-toggle');
          $browser->click('div.footable-row-detail-value > form > button')
                  ->assertDialogOpened('Do you really want to delete?')
                  ->acceptDialog();
          $browser->assertSee('Ticket has been deleted');
                  //->screenshot('delete_ticket');

      });
    }

    /* Restore the first ticket in tickets index page */
    public function testAdminRestoreTicket()
    {
      $this->browse(function (Browser $browser) {
          $browser->visit('/trash');
          $browser->press('table > tbody > tr:nth-child(1) > td.footable-first-column > span.footable-toggle');
          $browser->click('div.footable-row-detail-value > a')
                  ->assertSee('Ticket has been restored');
                  //->screenshot('restore_ticket');

      });
    }

}
