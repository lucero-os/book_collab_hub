<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function sections()
    {
        return $this->hasMany('BookSection');
    }
}
