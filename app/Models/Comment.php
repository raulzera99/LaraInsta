<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model{
    use HasFactory;

    protected $fillable = [
        'content',
    ];

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function profile(){
        return $this->belongsTo(Profile::class);
    }

    public function rules(){
        return [
            'content' => 'required|string|max:255',
        ];
    }

    public function feedback(){
        return [
            'required' => 'The :attribute field is required.',
            'content.min' => 'The :attribute must be at least 3 characters.',
            'content.max' => 'The :attribute may not be greater than 255 characters.',
        ];
    }

}
