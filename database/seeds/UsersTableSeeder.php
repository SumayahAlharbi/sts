<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
        [
          'name' => 'admin',
          'email' => 'admin@admin.com',
          'password' => Hash::make('123123'),
        ],
        [
          'name' => 'agent',
          'email' => 'agent@agent.com',
          'password' => Hash::make('123123'),
        ],
      ]);
    }
}
