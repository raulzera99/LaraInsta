<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user)
    {
        $profile = Profile::create([
            'title' => $user->username,
            'description' => 'This is the description of ' . $user->username,
            'url' => route('profiles.show', $user->id),
        ]);

        $profile->user()->associate($user);
        $profile->save();

        $user->profile_id = $profile->id;
        $user->save();
    }

    public function creating(User $user){
        // $profile = new Profile();
        // $profile->title = $user->username;
        // $profile->description = 'This is the description of ' . $user->username;
        // $profile->url = 'https://www.example.com';

        // // Obtém o usuário autenticado, se disponível
        // $authenticatedUser = Auth::user();

        // if ($authenticatedUser) {
        //     $profile->user_id = $authenticatedUser->id;
        //     $authenticatedUser->profile()->save($profile);
        // } else {
        //     $profile->user_id = $user->id;
        //     $user->profile()->save($profile);
        // }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
