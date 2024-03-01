<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model{
    use HasFactory;

    protected $fillable = [
        'caption'
    ];

    public function profile(){
        return $this->belongsTo(Profile::class);
    }

    public function medias(){
        return $this->hasMany(Media::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->hasMany(Like::class); 
    }

    public function rules(){
        return [
            'caption' => 'required|string|max:255',
        ];
    }

    public function feedback(){
        return [
            'required' => 'The :attribute field is required.',
            'caption.min' => 'The :attribute must be at least 3 characters.',
            'caption.max' => 'The :attribute may not be greater than 255 characters.',
        ];
    }
}
