<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function sections()
    {
        return $this->hasMany('BookSection');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'book_permission_user')->withPivot('permission_id');
    }
}
