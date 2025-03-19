<?php

namespace App\Services;

use App\Exceptions\CustomErrorException;
use App\Models\Book;
use App\Models\Permission;
use App\Models\User;

class UserService
{
    public function getData()
    {
        $userId = auth()->user()->id;

        return User::with('books', 'roles.permissions')->find($userId);
    }

    public function addBookPermission($data)
    {
        $loggedUser = $this->getData();
        if(!$loggedUser->hasRole('book_author')) throw new CustomErrorException('Action not available');

        $user = User::find($data['userId']);
        if(!$user) throw new CustomErrorException('User not found');

        $book = Book::find($data['bookId']);
        if(!$book) throw new CustomErrorException('Book not found');

        if(!$user->hasBookPermission($data['bookId'], $data['permissionCode'])){
            $permission = Permission::where('code', $data['permissionCode'])->first();
            $user->books()->attach($data['bookId'], ['permission_id' => $permission->id]);
        }
    }
}
