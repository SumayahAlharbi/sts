<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
  * Seed the application's database.
  *
  * @return void
  */
  public function run()
  {
    $this->call(UsersTableSeeder::class);
    $this->call(PermissionsTableSeeder::class);
    $this->call(RolesTableSeeder::class);
    $this->call(ModelHasRolesTableSeeder::class);
    $this->call(RegionsTableSeeder::class);
    $this->call(GroupsTableSeeder::class);
    $this->call(GroupUserTableSeeder::class);
    $this->call(LocationsTableSeeder::class);
    $this->call(CategoriesTableSeeder::class);
    $this->call(StatusesTableSeeder::class);
    $this->call(TicketsTableSeeder::class);
  }
}
