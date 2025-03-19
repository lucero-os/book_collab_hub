<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create a user with the 'author' role
        $author = User::factory()->create([
            'name' => 'Author User',
            'email' => 'author@example.com',
            'password' => 'secretAuthor'
        ]);

        $adminRole = Role::where('code', 'book_author')->pluck('id');
        $author->roles()->attach($adminRole);

        // Create a user with the 'collaborator' role
        $collaborator = User::factory()->create([
            'name' => 'Collaborator User',
            'email' => 'collaborator@example.com',
            'password' => 'secretCollab'
        ]);

        $collaboratorRole = Role::where('code', 'book_collaborator')->pluck('id');
        $collaborator->roles()->attach($collaboratorRole);
    }
}
