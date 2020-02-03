<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;

class SupervisorTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testSupervisorCanLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login');
            $browser->clickLink('Admin');
            $browser->type('email', env('TEST_SUPERVISOR_ROLE_USER'));
            $browser->type('password', env('TEST_SUPERVISOR_ROLE_PASSWORD'));
            $browser->press('LOGIN');
            $browser->assertPathIs('/');
        });
    }

   
    //        view,create,edit tickets
   
    public function testSupervisorCreateTicket()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/ticket');
            $browser->visit('/ticket/create');
            $browser->type('ticket_title', 'test ticket ' . Carbon::now()->toDateTimeString());
            $browser->script("CKEDITOR.instances['contentEditor'].setData('Test Data');");
            $browser->pause(4000);
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

    public function testSupervisorViewTicket()
    {
        $this->browse(function ($browser) {
            $browser->visit('/ticket')
                    ->clickLink('test ticket')
                    ->assertSee('test ticket');
        });
    }

    public function testSupervisorEditTicket()
    {
        $this->browse(function (Browser $browser) {
            $this->browse(function ($browser) {
                $browser->visit('/ticket')
                        ->clickLink('test ticket')
                        ->assertVisible('#main-wrapper > div.page-wrapper > div > div.container > div.button-box.text-right > a.btn.btn-outline-success');
            });
        });
    }

    //         add comment to ticket

    public function testSupervisorAddCommentToTicket()
    {
        $this->browse(function (Browser $browser) {
            $this->browse(function ($browser) {
                $browser->visit('/ticket')
                        ->clickLink('test ticket')
                        ->assertSee('Add comment');
            });
        });
    }


    //         change ticket status

    public function testSupervisorEditTicketStatus()
    {
        $this->browse(function (Browser $browser) {
            $this->browse(function ($browser) {
                $browser->visit('/ticket')
                        ->clickLink('test ticket')
                        ->assertVisible('#main-wrapper > div.page-wrapper > div > div.container > div.button-box.text-right > button.btn.btn-outline-success');
            });
        });
    }

    //         Asign and Unasign Agent to Ticket

    public function testSupervisorAssignAgentToTicket()
    {
        $this->browse(function (Browser $browser) {
            $this->browse(function ($browser) {
                $browser->visit('/ticket')
                        ->clickLink('test ticket')
                        ->assertVisible('#main-wrapper > div.page-wrapper > div > div.container > div.button-box.text-right > button.btn.btn-outline-info');
            });
        });
    }

    // public function testSupervisorUnassignAgentToTicket()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $this->browse(function ($browser) {
    //             $browser->visit('/ticket')
    //                     ->clickLink('test ticket')
    //                     ->press('#main-wrapper > div.page-wrapper > div > div.container > div.button-box.text-right > button.btn.btn-outline-info');
    //             $browser->select('#assignModal > div > div > div.modal-body > form > div.form-group.col-md-12 > div > select','Agent user')
    //                     //->select('Agent user')
    //                     ->press('#assignModal > div > div > div.modal-footer > button.btn.btn-primary');
    //                     //->seePageIs('/ticket/32345');
    //                    // ->press('');
    //                    // ->visit('/ticket/32345');
        
    //         });
    //     });
    // }

    //         Export Tickets

    public function testSupervisorExportTicket()
    {
        $this->browse(function (Browser $browser) {
            $this->browse(function ($browser) {
                $browser->visit('/Exports')
                        ->assertSee('Generate & Download');
            });
        });
    }

    //          View, Create, and edit locations

    public function testSupervisorViewLocation()
    {
        $this->browse(function ($browser) {
            $browser->visit('/location')
                    ->assertSee('All Locations');
        });
    }

    public function testSupervisorCreateLocation()
    {
        $this->browse(function ($browser) {
            $browser->visit('/location/create')
                    ->type('location_name','testing')
                    ->type('location_description','somewehere -jeddah')
                    ->press('Add')
                    ->assertSee('Location has been added');
        });
    }

    public function testSupervisorEditLocation()
    {
        $this->browse(function ($browser) {
            $browser->visit('/location')
                    ->assertSee('Edit');
        });
    }

    //          View, Create, and Edit Categories

    public function testSupervisorViewCategory()
    {
        $this->browse(function ($browser) {
            $browser->visit('/category')
                    ->assertSee('All Categories');
        });
    }

    public function testSupervisorCreateCategory()
    {
        $this->browse(function ($browser) {
            $browser->visit('/category/create')
                    ->type('category_name','testing category')
                    ->press('Add')
                    ->assertSee('Category has been added');
        });
    }

    public function testSupervisorEditCategory()
    {
        $this->browse(function ($browser) {
            $browser->visit('/category')
                    ->assertSee('Edit');
        });
    }

    //          Access Deleted Tickets

    public function testSupervisorViewTrashedTickets()
    {
        $this->browse(function ($browser) {
            $browser->visit('/trash')
                    ->assertSee('Deleted Ticket List');
        });
    }

    //          Generate Reports

    public function testSupervisorGenerateReport()
    {
        $this->browse(function ($browser) {
            $browser->visit('/Reports')
                    ->assertSee('Generate & Download');
        });
    }
    
}
