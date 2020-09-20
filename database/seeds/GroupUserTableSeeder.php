<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class GroupUserTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    DB::table('group_user')->insert([
      [
        'group_id' => '1',
        'user_id' => '1',
      ],
      [
        'group_id' => '1',
        'user_id' => '2',
      ]
    ]);
  }
}
