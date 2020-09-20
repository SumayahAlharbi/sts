<?php
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // create roles and assign created permissions
      // this can be done as separate statements
      $role = Role::firstOrCreate(['name' => 'admin']);

      // or may be done by chaining
      $role = Role::firstOrCreate(['name' => 'agent'])
      ->givePermissionTo(['create ticket'])
      ->givePermissionTo(['show ticket'])
      ->givePermissionTo(['change ticket status'])
      ->givePermissionTo(['view tickets list']);

      $role = Role::firstOrCreate(['name' => 'supervisor'])
      ->givePermissionTo(['create ticket'])
      ->givePermissionTo(['update ticket'])
      ->givePermissionTo(['show ticket'])
      ->givePermissionTo(['delete ticket'])
      ->givePermissionTo(['change ticket status'])
      ->givePermissionTo(['view tickets list'])
      ->givePermissionTo(['view group tickets'])
      ->givePermissionTo(['assign ticket'])
      ->givePermissionTo(['unassign ticket'])
      ->givePermissionTo(['export tickets'])
      ->givePermissionTo(['view location list'])
      ->givePermissionTo(['create location'])
      ->givePermissionTo(['update location'])
      ->givePermissionTo(['view category list'])
      ->givePermissionTo(['create category'])
      ->givePermissionTo(['update category'])
      ->givePermissionTo(['view trashed tickets'])
      ->givePermissionTo(['restore ticket']);

      $role = Role::firstOrCreate(['name' => 'manager'])
      ->givePermissionTo(['create ticket'])
      ->givePermissionTo(['update ticket'])
      ->givePermissionTo(['show ticket'])
      ->givePermissionTo(['delete ticket'])
      ->givePermissionTo(['change ticket status'])
      ->givePermissionTo(['view tickets list'])
      ->givePermissionTo(['view group tickets'])
      ->givePermissionTo(['assign ticket'])
      ->givePermissionTo(['unassign ticket'])
      ->givePermissionTo(['export tickets'])
      ->givePermissionTo(['view location list'])
      ->givePermissionTo(['create location'])
      ->givePermissionTo(['update location'])
      ->givePermissionTo(['view category list'])
      ->givePermissionTo(['create category'])
      ->givePermissionTo(['update category']);

      $role = Role::firstOrCreate(['name' => 'helpdesk'])
      ->givePermissionTo(['create ticket'])
      ->givePermissionTo(['update ticket'])
      ->givePermissionTo(['show ticket'])
      ->givePermissionTo(['delete ticket'])
      ->givePermissionTo(['change ticket status'])
      ->givePermissionTo(['view tickets list'])
      ->givePermissionTo(['view group tickets'])
      ->givePermissionTo(['assign ticket'])
      ->givePermissionTo(['unassign ticket'])
      ->givePermissionTo(['export tickets'])
      ->givePermissionTo(['view trashed tickets'])
      ->givePermissionTo(['restore ticket']);

      $role = Role::firstOrCreate(['name' => 'enduser'])
      ->givePermissionTo(['create ticket'])
      ->givePermissionTo(['show ticket'])
      ->givePermissionTo(['view tickets list'])
      ->givePermissionTo(['rate ticket']);
    }
}
