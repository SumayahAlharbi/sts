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
            $browser->type('email', env('TEST_ENDUSER_ROLE_USER'));
            $browser->type('password', env('TEST_ENDUSER_ROLE_PASSWORD'));
            // $browser->pause(3000);
            $browser->press('LOGIN');
            // $browser->pause(3000);
            $browser->assertPathIs('/');
        });
    }

    public function testEnduserCreateTicket()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/ticket');
            $browser->visit('/ticket');
            $browser->visit('/ticket/create');
            $browser->type('ticket_title', 'test ticket ' . Carbon::now()->toDateTimeString());
            //$browser->select('High', 'priority');
            $browser->script("CKEDITOR.instances['contentEditor'].setData('Test Data');");
            $browser->pause(3000);
            $browser->select('region','1');
            $browser->select('group_id','1');
            $browser->select('location_id','1');
            $browser->select('category_id','2');
            $browser->type('room_number','324');
            $browser->press('Create')
                    ->assertSee('Comments')
                    ->screenshot('home-page');
        });
    }
}
