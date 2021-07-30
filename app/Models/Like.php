<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Like extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function likeable()
    {
        return $this->morphTo();
    }
}
