<?php

namespace App\Http\Services;

use console;
use App\Models\User;
use App\Models\Media;
use App\Models\Profile;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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

    public function search($search){
        $profiles = $this->repository->where('title', 'like', '%'.$search.'%')->get()->toArray();

        if(!$profiles){
            return ([ 
                'error' => 'Profiles not found'
                , 'success' => null
            ]);
        }

        return ([
            'data' => $profiles,
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
        //Save new profile image
        $profileImage = $request->file('profile_image');
        $profileImageName = time() . '.' . $profileImage->extension();
        $newData['profile_image']->storeAs('public/profile_images', $profileImageName);

        // Delete old profile image if it exists
        if ($profile->profileImage && $profile->profileImage->path !== '/no-logo.png') {
            $oldProfileImage = $profile->profileImage->path;
            File::delete(storage_path('public/profile_images/' . $oldProfileImage));
            $profile->profileImage->delete();
        }

        if ($profile->profileImage) {
            // Atualiza a imagem existente
            $profile->profileImage->path = $profileImageName;
            $profile->profileImage->save();
        } else {
            // Cria uma nova imagem de perfil
            $media = new Media([
                'path' => $profileImageName,
            ]);
            $profile->profileImage()->save($media);
        }
        
    } else {
        $newData['profile_image'] = $profile->profileImage->path;
    }

    $profile->title = $newData['title'];
    $profile->description = $newData['description'];

    $profile->save();

    return ([
        'user' => $user,
        'profile' => $user->profile,
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

    // public function deleteProfileImage($id, $profileImage, $path){
    //     $data = $this->repository->find($id);

    //     if(!$data){
    //         return ([ 'error' => 'Profile not found',
    //             'success' => null]);
    //     }

    //     if(file_exists($path) == false || is_file($path) == false || empty($profileImage)){
    //         return ([ 'error' => 'Profile image not found',
    //             'success' => null]);
    //     }

    //     $data->update([
    //         'profile_image' => null
    //     ]);

    //     unlink($path);
    //     $profileImage->delete();

    //     return ([
    //         'user' => $data,
    //         'profile' => $data,
    //         'success' => 'Profile image deleted successfully',
    //         'error' => null
    //     ]);

    // }

    public function deleteProfileImage($profileId, $profileImage){
        $data = $this->repository->find($profileId);

        if (!$data) {
            return [
                'error' => 'Profile not found',
                'success' => null
            ];
        }

        if (!$profileImage->path || !$profileImage) {
            return [
                'error' => 'Profile image not found',
                'success' => null
            ];
        }

        $imagePath = public_path('storage/profile_images/' . $profileImage->path);

        if(!File::exists($imagePath)){
            return [
                'error' => 'Profile image file not found',
                'success' => null
            ];
        }

        $data->update([
            'profile_image' => null
        ]);

        File::delete($imagePath);
        // $profileImage->delete();
        $profileImage->update([
            'path' => 'no-logo.png'
        ]);

        return [
            'user' => $data->user,
            'profile' => $data,
            'success' => 'Profile image deleted successfully',
            'error' => null
        ];
    }

    public function follow($request, $profileId){
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

        // Verifique se o usuário autenticado não é o próprio perfil que está sendo visualizado
        if ($request->user()->id !== $profile->user->id) {
            // Verifique se o usuário já está seguindo o perfil
            if (!$request->user()->profile->following()->where('user_to_id', $profile->user->id)->exists()) {
                // Crie uma nova entrada na tabela followers
                $request->user()->profile->following()->attach($profile->user->id);
            }
        }

        return ([
            'user' => $request->user(),
            'profile' => $profile,
            'success' => 'Profile followed successfully',
            'error' => null
        ]);

    }

    public function unfollow($request, $profileId){
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

        // Verifique se o usuário autenticado não é o próprio perfil que está sendo visualizado
        if ($request->user()->id !== $profile->user->id) {
            // Verifique se o usuário já está seguindo o perfil
            if ($request->user()->profile->following()->where('user_to_id', $profile->user->id)->exists()) {
                // Crie uma nova entrada na tabela followers
                $request->user()->profile->following()->detach($profile->user->id);
            }
        }

        return ([
            'user' => $request->user(),
            'profile' => $profile,
            'success' => 'Profile unfollowed successfully',
            'error' => null
        ]);

    }

    // public function unfollow($request, $profileId){
    //     $profile = $this->repository->find($profileId);

    //     if(!$profile){
    //         return ([ 'error' => 'Profile not found'
    //             , 'success' => null
    //         ]);
    //     }

    //     if(!auth()){
    //         return ([ 'error' => 'You must be logged in to unfollow a profile'
    //             , 'success' => null
    //         ]);
    //     }
    //     else {
    //         $user = Auth::user();
    //         $follower = Follower::where('profile_from_id', $user()->profile->id)
    //             ->where('profile_to_id', $profile->id)
    //             ->first();

    //         $follower->delete();
    //     }
    // }

}