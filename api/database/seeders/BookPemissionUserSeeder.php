<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookPemissionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::with('roles.permissions')->get();
        $books = Book::all();

        foreach($users as $user){
            $this->attachBookPermissionsByRole($user, $books, 'book_author');
            $this->attachBookPermissionsByRole($user, $books, 'book_collaborator');
        }
    }

    /**
     * Attach initial book permissions depending on role
     */
    private function attachBookPermissionsByRole($user, $books, $roleCode)
    {
        foreach($user->roles as $role){
            if($role->code == $roleCode){
                foreach($role->permissions as $permission){
                    foreach($books as $book){
                        $user->books()->attach($book->id, ['permission_id' => $permission->id]); // Admin can edit Book 1
                    }
                }
            }
        }
    }
}
