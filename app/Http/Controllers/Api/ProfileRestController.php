<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Services\UserServiceInterface;
use App\Http\Services\ProfileServiceInterface;

//     Route::any('/index', [ProfileRestController::class, 'index']);
//     Route::any('/{profile}', [ProfileRestController::class, 'show']);
//     Route::post('/store', [ProfileRestController::class, 'store']);
//     Route::put('/{profile}', [ProfileRestController::class, 'update']);
//     Route::delete('/{profile}', [ProfileRestController::class, 'destroy']);

class ProfileRestController extends Controller{
    private $service, $userService;

    //Constructor
    public function __construct(ProfileServiceInterface $profileService, UserServiceInterface $userService){
        $this->service = $profileService;
        $this->userService = $userService;
    }

    public function index(){
        $profiles = $this->service->index();
        $users = $this->userService->index();

        return response()->json([
            'users' => $users['users'],
            'profiles' => $profiles['profiles'],
            'error' => $profiles['error'],
            'success' => $profiles['success'],
        ], 200);
    }

    public function show(Profile $profile){
        $data = $this->service->find($profile->id);

        if($data['error']){
            return response()->json([
                'error' => $data['error'], 
                'success' => null,
                'profile' => null
            ], 404);
        }

        return response()->json([ 
            'profile' => $data['profile'],
            'success' => $data['success'],
            'error' => $data['error']
        ], 200);
    }

    public function store(StoreProfileRequest $request){
        $data = $this->service->store($request);

        if($data['error']){
            return response()->json([
                'error' => $data['error'], 
                'success' => null,
                'profile' => null
            ], 404);
        }

        return response()->json([ 
            'profile' => $data['profile'],
            'success' => $data['success'],
            'error' => $data['error']
        ], 200);
    }

    public function update(UpdateProfileRequest $request, Profile $profile){
        $data = $this->service->update($request, $profile->id);

        if($data['error']){
            return response()->json([
                'error' => $data['error'], 
                'success' => null,
                'profile' => null
            ], 404);
        }

        return response()->json([ 
            'profile' => $data['profile'],
            'success' => $data['success'],
            'error' => $data['error']
        ], 200);
    }

    public function destroy(Profile $profile){
        $data = $this->service->destroy($profile->id);

        if($data['error']){
            return response()->json([
                'error' => $data['error'], 
                'success' => null,
                'profile' => null
            ], 404);
        }

        return response()->json([ 
            'profile' => $data['profile'],
            'success' => $data['success'],
            'error' => $data['error']
        ], 200);
    }

}
