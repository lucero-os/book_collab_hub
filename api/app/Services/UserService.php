<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getData()
    {
        $userId = auth()->user()->id;

        return User::with('books', 'roles.permissions')->find($userId);
    }
}
