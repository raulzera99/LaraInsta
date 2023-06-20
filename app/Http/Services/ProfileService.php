<?php

namespace App\Http\Services;

use console;
use App\Models\User;
use App\Models\Media;
use App\Models\Profile;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Services\ProfileServiceInterface;

class ProfileService implements ProfileServiceInterface{
    private $repository;

    //Constructor
    public function __construct(Profile $profileModel){
        $this->repository = $profileModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(){
        $profiles = $this->repository->all();

        if(!$profiles){
            return ([ 'error' => 'Profiles not found'
                , 'success' => null
            ]);
        }

        return ([
            'profiles' => $profiles,
            'error' => null,
            'success' => 'Profiles found successfully'
        ]);
    }

     /**
     * Search the specified resource.
     */
    public function find($profile){
        $data = $this->repository->findOrFail($profile);

        if(!$data){
            return ([ 'error' => 'Profile not found'
                , 'success' => null
            ]);
        }

        return ([
            'profile' => $data,
            'success' => 'Profile found successfully',
            'error' => null
        ]);
    }

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $userId){
    if (!auth()->check() || auth()->user()->id != $userId) {
        return [
            'error' => 'You must be logged in to update a profile',
            'success' => null,
        ];
    }

    $user = User::find($userId);

    if (!$user) {
        return [
            'error' => 'User not found',
            'success' => null,
        ];
    }

    $profile = $user->profile;

    if (!$profile) {
        $profile = new Profile();
        $profile->user()->associate($user);
    }

    $newData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'profile_image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
    ]);

    if ($request->hasFile('profile_image')) {
        $profileImage = $request->file('profile_image');
        $profileImageName = time() . '.' . $profileImage->extension();
        $newData['profile_image']->storeAs('public/profile_images', $profileImageName);

        $media = new Media([
            'path' => $profileImageName,
        ]);

        $profile->profileImage()->save($media);
    } else {
        // Verifica se já existe uma imagem de perfil associada ao perfil
        if (!$profile->profileImage) {
            $media = new Media([
                'path' => '/no-logo.png', // Imagem padrão 'no-logo'.png
            ]);

            $profile->profileImage()->save($media);
        }
    }

    $profile->title = $newData['title'];
    $profile->description = $newData['description'];

    $profile->save();

    return ([
        'profile' => $profile,
        'success' => 'Profile updated successfully',
        'error' => null,
    ]);
}

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($profile){
        $data = $this->repository->find($profile);

        if(!$data){
            return ([ 'error' => 'Profile not found'
                , 'success' => null
            ]);
        }

        $data = $data->delete();

        if(!$data){
            return ([ 'error' => 'Profile not deleted'
                , 'success' => null
            ]);
        }

        return ([
            'profile' => $data,
            'success' => 'Profile deleted successfully',
            'error' => null
        ]);
    }

    public function deleteProfileImage($id, $profileImage, $path){
        $data = $this->repository->find($id);

        if(!$data){
            return ([ 'error' => 'Profile not found',
                'success' => null]);
        }

        if(file_exists($path) == false || is_file($path) == false || empty($profileImage)){
            return ([ 'error' => 'Profile image not found',
                'success' => null]);
        }

        $data->update([
            'profile_image' => null
        ]);

        unlink($path);
        $profileImage->delete();

        return ([
            'success' => 'Profile image deleted successfully',
            'error' => null
        ]);

    }

    public function follow($profileId){

        $profile = $this->repository->find($profileId);

        if(!$profile){
            return ([ 'error' => 'Profile not found'
                , 'success' => null
            ]);
        }

        if(!auth()){
            return ([ 'error' => 'You must be logged in to follow a profile'
                , 'success' => null
            ]);
        }
        else {
            $user = Auth::user();
            Follower::create([
                'profile_from_id' => $user()->profile->id,
                'profile_to_id' => $profile->id
            ]);
        }
    }

    public function unfollow($profileId){
        $profile = $this->repository->find($profileId);

        if(!$profile){
            return ([ 'error' => 'Profile not found'
                , 'success' => null
            ]);
        }

        if(!auth()){
            return ([ 'error' => 'You must be logged in to unfollow a profile'
                , 'success' => null
            ]);
        }
        else {
            $user = Auth::user();
            $follower = Follower::where('profile_from_id', $user()->profile->id)
                ->where('profile_to_id', $profile->id)
                ->first();

            $follower->delete();
        }
    }

}