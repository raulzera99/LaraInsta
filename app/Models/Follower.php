<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model{
    use HasFactory;

    protected $fillable = [
        'profile_from_id',
        'profile_to_id',
    ];

    public function profile(){
        return $this->belongsTo(Profile::class);
    }
}
