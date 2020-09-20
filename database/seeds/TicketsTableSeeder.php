<?php
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Database\Seeder;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('tickets')->insert([
        [
          'ticket_title' => 'Ticket 1 - Admin Test',
          'ticket_content' => 'Content',
          'group_id' => '1',
          'status_id' => '3',
          'location_id' => '1',
          'category_id' => '1',
          'created_by' => '1',
          'priority' => 'Low',
          'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ],
        [
          'ticket_title' => 'Ticket 2 - Admin Test',
          'ticket_content' => 'Content',
          'group_id' => '1',
          'status_id' => '3',
          'location_id' => '2',
          'category_id' => '2',
          'created_by' => '1',
          'priority' => 'High',
          'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ],
        ]);
    }
}
