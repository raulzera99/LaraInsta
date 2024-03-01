<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'url',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function profileImage(){
        return $this->hasOne(Media::class);
    }

    public function followers(){
        return $this->belongsToMany(Profile::class, 'followers', 'profile_to_id', 'profile_from_id');
    }

    public function following(){
        return $this->belongsToMany(Profile::class, 'followers', 'profile_from_id', 'profile_to_id');
    }

    public function isFollowing(Profile $profile){
        return $this->following()->where('profile_id', $profile->id)->exists();
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }


    // public function getProfileImageAttribute()
    // {
    //     return $this->profileImage()->first();
    // }

    public function rules(){
        return [
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3|max:255',
            'url' => 'url',
        ];
    }

    public function feedback(){
        return [
            'required' => 'The :attribute field is required.',
            'title.min' => 'The :attribute must be at least 3 characters.',
            'title.max' => 'The :attribute may not be greater than 255 characters.',
            'description.min' => 'The :attribute must be at least 3 characters.',
            'description.max' => 'The :attribute may not be greater than 255 characters.',
            'url.url' => 'The :attribute format is invalid.',
        ];
    }

}
