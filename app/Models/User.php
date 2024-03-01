<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Profile;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot() {
        parent::boot();

        // static::created(function ($user) {
        //     $user->profile()->create([
        //         'title' => $user->username,
        //     ]);
        // });

        //Mail::to($user->email)->send(new NewUserWelcomeMail());
    }

    public function rules(){
        return [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ];
    }

    public function feedback(){
        return [
            'required' => 'The :attribute field is required.',
            'firstname.min' => 'The :attribute must be at least 3 characters.',
            'firstname.max' => 'The :attribute may not be greater than 255 characters.',
            'lastname.min' => 'The :attribute must be at least 3 characters.',
            'lastname.max' => 'The :attribute may not be greater than 255 characters.',
            'username.min' => 'The :attribute must be at least 3 characters.',
            'username.max' => 'The :attribute may not be greater than 255 characters.',
            'email.min' => 'The :attribute must be at least 3 characters.',
            'email.max' => 'The :attribute may not be greater than 255 characters.',
            'password.min' => 'The :attribute must be at least 8 characters.',
            'password.confirmed' => 'The :attribute confirmation does not match.',
        ];
    }

    public function profile() {
        return $this->hasOne(Profile::class);
    }

    public function roles() {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
}
