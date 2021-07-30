<?php

namespace App\Models;

use Auth;
use App\Models\LikesTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, LikesTrait;

    protected $guarded = ['id'];
    

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment')->withCount('likes')
                    ->orderBy('created_at', 'desc');
    }
    
}