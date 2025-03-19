<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Creating roles
        $bookAuthorRole = Role::create(['code' => 'book_author', 'name' => 'Book author']);
        $bookCollaboratorRole = Role::create(['code' => 'book_collaborator', 'name' => 'Book collaborator']);

        // Assign all permissions to the admin
        $authorPermissions = Permission::pluck('id');
        $bookAuthorRole->permissions()->attach($authorPermissions);

        // Assign all permissions to the collaborator
        $collaboratorPermissions = Permission::whereIn('code', ['edit_book_section', 'read_book_section'])->pluck('id');
        $bookCollaboratorRole->permissions()->attach($collaboratorPermissions);
    }
}
