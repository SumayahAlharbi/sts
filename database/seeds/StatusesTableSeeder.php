<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('statuses')->insert([
        [
          'status_name' => 'Completed',
        ],
        [
          'status_name' => 'Scheduled',
        ],
        [
          'status_name' => 'Unassigned',
        ],
        [
          'status_name' => 'Pending',
        ],
        [
          'status_name' => 'In Progress',
        ],
      ]);
    }
}
