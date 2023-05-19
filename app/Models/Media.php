<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model{
    use HasFactory;

    protected $table = 'medias';
    
    protected $fillable = [
        'path',
    ];

    public function profile(){
        return $this->belongsTo(Profile::class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function rules(){
        return [
            'path' => 'required|string|max:255',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
    
    public function feedback(){
        return [
            'required' => 'The :attribute field is required.',
            'path.min' => 'The :attribute must be at least 3 characters.',
            'path.max' => 'The :attribute may not be greater than 255 characters.',
        ];
    }

}
