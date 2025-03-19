<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Creating permissions
        Permission::create(['code' => 'edit_permissions', 'desc' => 'Edit user permissions']);
        Permission::create(['code' => 'create_book_section', 'desc' => 'Create book section']);
        Permission::create(['code' => 'edit_book_section', 'desc' => 'Edit book section']);
        Permission::create(['code' => 'read_book_section', 'desc' => 'Read book section']);
        Permission::create(['code' => 'delete_book_section', 'desc' => 'Delete book section']);
    }
}
