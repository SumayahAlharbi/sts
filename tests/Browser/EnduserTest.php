<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
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
            $browser->visit('/ticket/create');
            $browser->type('ticket_title', 'test ticket ' . Carbon::now()->toDateTimeString());
            //$browser->select('High', 'priority');
            $browser->script("CKEDITOR.instances['contentEditor'].setData('Test Data');");
            $browser->pause(3000);
            $browser->select('region','1');
            $browser->waitFor('.group');
            $browser->select('group_id','5');
            $browser->waitFor('#location_id');
            $browser->select('location_id','9');
            $browser->waitFor('#categoryDiv');
            $browser->select('category_id','10');
            $browser->type('room_number','324');
            $browser->press('Create')
                    ->assertSee('Comments')
                    ->screenshot('home-page');
        });
    }

    public function testEnduserViewTicket()
    {
        $this->browse(function ($browser) {
            $browser->visit('/ticket')
                    ->clickLink('test ticket')
                    ->assertSee('test ticket');
        });
    }

    public function testEnduserEditTicket()
    {
        $this->browse(function (Browser $browser) {
            $this->browse(function ($browser) {
                $browser->visit('/ticket')
                        ->clickLink('test ticket')
                        ->assertMissing('#main-wrapper > div.page-wrapper > div > div.container > div.button-box.text-right > a.btn.btn-outline-success');
            });
        });
    }
    public function testEnduserAddCommentToTicket()
    {
        $this->browse(function (Browser $browser) {
            $this->browse(function ($browser) {
                $browser->visit('/ticket')
                        ->clickLink('test ticket')
                        ->assertSee('Add comment');
            });
        });
    }
    // public function testEnduserDeleteCommentOnTicket()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $this->browse(function ($browser) {
    //             $browser->visit('/ticket')
    //                     ->clickLink('test ticket')
    //                     ->script("CKEDITOR.instances['editor'].setData('Test Comment');");
    //             $browser->pause(3000);
    //             $browser->press('Add Comment')
    //                     ->assertSee('Test Comment');
    //             $browser->mouseover('#main-wrapper > div.page-wrapper > div > div.container > div:nth-child(8) > div > div > div.comment-widgets > div.display-comment > div > div.comment-text.w-100 > div > span.action-icons > form > button')
    //                      ->assertVisible('#main-wrapper > div.page-wrapper > div > div.container > div:nth-child(8) > div > div > div.comment-widgets > div.display-comment > div > div.comment-text.w-100 > div > span.action-icons > form > button');
    //             $browser->acceptDialog() 
    //                     ->assertSee('This comment has been deleted');
    //         });
    //     });
    // }
    public function testEnduserDeleteTicket()
    {
        $this->browse(function (Browser $browser) {
            $this->browse(function ($browser) {
                $browser->visit('/ticket')
                        ->clickLink('test ticket')
                        ->assertMissing('Delete');
            });
        });
    }
    public function testEnduserRestoreTickets()
    {
        $this->browse(function (Browser $browser) {
            $this->browse(function ($browser) {
                $browser->visit('/trash')
                        ->assertMissing('restore');
            });
        });
    }

    public function testEnduserAccessTrashedTickets()
    {
        $this->browse(function (Browser $browser) {
            $this->browse(function ($browser) {
                $browser->visit('/')
                        ->assertMissing('Trashed');
            });
        });
    }
}
