<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('regions')->insert([
        [
          'name' => 'Jeddah',
        ],
        [
          'name' => 'Riyadh',
        ]
      ]);
    }
}
