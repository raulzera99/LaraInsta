<?php

namespace App\Http\Services;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Services\ProfileServiceInterface;
use App\Models\User;

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

    public function self(){
        $user = auth()->user();

        if($user){
            return [
                'user' => $user,
                'error' => false,
                'success' => true,
            ];
        }
        else{
            return [
                'user' => null,
                'error' => false,
                'success' => true,
            ];
        }
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        // $data = $request->validate($this->repository->rules());
        
        // $data['password'] = bcrypt($data['password']);

        // $data = $this->repository->create($data);

        // if(!$data){
        //     return ([ 'error' => 'Profile not created'
        //         , 'success' => null
        //     ]);
        // }

        // return ([
        //     'profile' => $data,
        //     'success' => 'Profile created successfully',
        //     'error' => null
        // ]);
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update($newData, $userId){
        $profile = User::find($userId)->profile;

        $profile = $profile->update($newData);

        if(!$profile){
            return ([ 'error' => 'Profile not updated'
                , 'success' => null
            ]);
        }

        return ([
            'profile' => $profile,
            'success' => 'Profile updated successfully',
            'error' => null
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

    // public function following($profile){
    //     $data = $this->repository->find($profile);

    //     if(!$data){
    //         return ([ 'error' => 'Profile not found'
    //             , 'success' => null
    //         ]);
    //     }

    //     $data = $data->following;

    //     if(!$data){
    //         return ([ 'error' => 'Profile not found'
    //             , 'success' => null
    //         ]);
    //     }

    //     return ([
    //         'profile' => $data,
    //         'success' => 'Profile found successfully',
    //         'error' => null
    //     ]);
    // }

    // public function followers($profile){
    //     $data = $this->repository->find($profile);

    //     if(!$data){
    //         return ([ 'error' => 'Profile not found'
    //             , 'success' => null
    //         ]);
    //     }

    //     $data = $data->followers;

    //     if(!$data){
    //         return ([ 'error' => 'Profile not found'
    //             , 'success' => null
    //         ]);
    //     }

    //     return ([
    //         'profile' => $data,
    //         'success' => 'Profile found successfully',
    //         'error' => null
    //     ]);
    // }

    // public function follow($profile){
    //     $data = $this->repository->find($profile);

    //     if(!$data){
    //         return ([ 'error' => 'Profile not found'
    //             , 'success' => null
    //         ]);
    //     }

    //     $data = $data->follow();

    //     if(!$data){
    //         return ([ 'error' => 'Profile not found'
    //             , 'success' => null
    //         ]);
    //     }

    //     return ([
    //         'profile' => $data,
    //         'success' => 'Profile found successfully',
    //         'error' => null
    //     ]);
    // }

    // public function unfollow($profile){
    //     $data = $this->repository->find($profile);

    //     if(!$data){
    //         return ([ 'error' => 'Profile not found'
    //             , 'success' => null
    //         ]);
    //     }

    //     $data = $data->unfollow();

    //     if(!$data){
    //         return ([ 'error' => 'Profile not found'
    //             , 'success' => null
    //         ]);
    //     }

    //     return ([
    //         'profile' => $data,
    //         'success' => 'Profile found successfully',
    //         'error' => null
    //     ]);
    // }

    // public function search($search){
    //     $data = $this->repository->where('name', 'like', '%'.$search.'%')->get();

    //     if(!$data){
    //         return ([ 'error' => 'Profile not found'
    //             , 'success' => null
    //         ]);
    //     }

    //     return ([
    //         'profile' => $data,
    //         'success' => 'Profile found successfully',
    //         'error' => null
    //     ]);
    // }



}