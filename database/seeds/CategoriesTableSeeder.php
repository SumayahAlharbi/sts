<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    DB::table('categories')->insert([
      [
        'category_name' => 'Hardware',
        'location_id' => '1',
        'group_id' => '1',
      ],
      [
        'category_name' => 'Software',
        'location_id' => '2',
        'group_id' => '1',
      ],
      [
        'category_name' => 'Hardware',
        'location_id' => '2',
        'group_id' => '2',
      ],
    ]);
  }
}
