<?php

namespace App\Models;

use App\Traits\SelfReferenceTrait;
use Illuminate\Database\Eloquent\Model;

class BookSection extends Model
{
    use SelfReferenceTrait;

    public function book()
    {
        return $this->belongsTo('Book');
    }
}
