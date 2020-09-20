<?php
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Reset cached roles and permissions
      app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

      // create permissions
      Permission::firstOrCreate(['name' => 'view group tickets']);
      Permission::firstOrCreate(['name' => 'change ticket status']);
      Permission::firstOrCreate(['name' => 'rate ticket']);
      Permission::firstOrCreate(['name' => 'show ticket']);
      Permission::firstOrCreate(['name' => 'update ticket']);
      Permission::firstOrCreate(['name' => 'delete ticket']);
      Permission::firstOrCreate(['name' => 'create ticket']);
      Permission::firstOrCreate(['name' => 'view tickets list']);
      Permission::firstOrCreate(['name' => 'assign ticket']);
      Permission::firstOrCreate(['name' => 'unassign ticket']);
      Permission::firstOrCreate(['name' => 'export tickets']);
      Permission::firstOrCreate(['name' => 'view location list']);
      Permission::firstOrCreate(['name' => 'create location']);
      Permission::firstOrCreate(['name' => 'update location']);
      Permission::firstOrCreate(['name' => 'delete location']);
      Permission::firstOrCreate(['name' => 'view category list']);
      Permission::firstOrCreate(['name' => 'create category']);
      Permission::firstOrCreate(['name' => 'update category']);
      Permission::firstOrCreate(['name' => 'delete category']);
      Permission::firstOrCreate(['name' => 'view trashed tickets']);
      Permission::firstOrCreate(['name' => 'restore ticket']);
      Permission::firstOrCreate(['name' => 'generate reports']);
    }
}
