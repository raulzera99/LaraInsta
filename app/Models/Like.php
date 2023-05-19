<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'post_id',
    ];

    public function profile(){
        return $this->belongsTo(Profile::class);
    }

    public function post(){
        return $this->hasMany(Post::class);
    }
}
