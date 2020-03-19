<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    DB::table('groups')->insert([
      [
        'group_name' => 'COMJ-IT',
        'group_description' => 'College of Medicine - Education Technology Services',
        'region_id' => '1',
      ],
      [
        'group_name' => 'ITS-J',
        'group_description' => 'Information Technology Services - Jeddah',
        'region_id' => '1',
      ]
    ]);
  }
}
