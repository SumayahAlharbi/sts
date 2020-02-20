<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    DB::table('locations')->insert([
      [
        'location_name' => 'COMJ - Male',
        'location_description' => 'College of medicine - Jeddah - Male',
        'group_id' => '1',
      ],
      [
        'location_name' => 'COMJ - Female',
        'location_description' => 'College of medicine - Jeddah - Female',
        'group_id' => '1',
      ],
      [
        'location_name' => 'COMJ - Male',
        'location_description' => 'College of medicine - Jeddah - Male',
        'group_id' => '2',
      ],

    ]);
  }
}
