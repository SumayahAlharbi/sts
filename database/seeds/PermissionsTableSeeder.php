<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      /*$permissions = factory(App\Permission::class)->create([
          'name' => 'view group tickets',
          'guard_name' => 'web',
      ]);*/

      DB::table('permissions')->insert([
        [
          'name' => 'view group tickets',
          'guard_name' => 'web',
        ],
        [
          'name' => 'change ticket status',
          'guard_name' => 'web',
        ],
        [
          'name' => 'rate ticket',
          'guard_name' => 'web',
        ],
        [
          'name' => 'show ticket',
          'guard_name' => 'web',
        ],
        [
          'name' => 'update ticket',
          'guard_name' => 'web',
        ],
        [
          'name' => 'delete ticket',
          'guard_name' => 'web',
        ],
        [
          'name' => 'create ticket',
          'guard_name' => 'web',
        ],
        [
          'name' => 'view tickets list',
          'guard_name' => 'web',
        ],
        [
          'name' => 'assign ticket',
          'guard_name' => 'web',
        ],
        [
          'name' => 'unassign ticket',
          'guard_name' => 'web',
        ],
        [
          'name' => 'export tickets',
          'guard_name' => 'web',
        ],
        [
          'name' => 'view location list',
          'guard_name' => 'web',
        ],
        [
          'name' => 'create location',
          'guard_name' => 'web',
        ],
        [
          'name' => 'update location',
          'guard_name' => 'web',
        ],
        [
          'name' => 'delete location',
          'guard_name' => 'web',
        ],
        [
          'name' => 'view category list',
          'guard_name' => 'web',
        ],
        [
          'name' => 'create category',
          'guard_name' => 'web',
        ],
        [
          'name' => 'update category',
          'guard_name' => 'web',
        ],
        [
          'name' => 'delete category',
          'guard_name' => 'web',
        ],
        [
          'name' => 'end user create ticket',
          'guard_name' => 'web',
        ],
        [
          'name' => 'view trashed tickets',
          'guard_name' => 'web',
        ],
        [
          'name' => 'restore ticket',
          'guard_name' => 'web',
        ],
        [
          'name' => 'generate reports',
          'guard_name' => 'web',
        ],
      ]);

    }
}
