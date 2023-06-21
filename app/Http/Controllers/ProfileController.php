<?php

namespace App\Http\Controllers;

use console;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Services\UserServiceInterface;
use App\Http\Services\ProfileServiceInterface;

class ProfileController extends Controller{
    private $service, $userService;

    //Constructor
    public function __construct(ProfileServiceInterface $profileService, UserServiceInterface $userService){
        $this->service = $profileService;
        $this->userService = $userService;
    }


    public function index(){
        $profiles = $this->service->index();
        $users = $this->userService->index();

        return view('profiles.index', [
            'users' => $users['users'],
            'profiles' => $profiles['profiles'],
            'error' => $profiles['error'],
            'success' => $profiles['success'],
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function manage(){
        $profiles = $this->service->index();
        $users = $this->userService->index();

        return view('profiles.manage', [
            'users' => $users['users'], 
            'profiles' => $profiles['profiles'],
            'error' => $profiles['error'],
            'success' => $profiles['success'],
        ]);

    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileRequest $request){
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($user){
        $user = $this->userService->find($user);

        if($user['error']){
            return redirect('/')->with('error', $user['error']);
        }
        //TODO: Fix this
        // $follows = (auth()->user()) ? $user['user']->profile->following : false;

        // $postCount = Cache::remember(
        //     'count.posts.' . $user->id,
        //     now()->addSeconds(30),
        //     function () use ($user) {
        //         return $user->posts->count();
        //     });

        // $followersCount = Cache::remember(
        //     'count.followers.' . $user['user']->id,
        //     now()->addSeconds(30),
        //     function () use ($user) {
        //         return $user->profile->followers->count();
        //     });

        // $followingCount = Cache::remember(
        //     'count.following.' . $user->id,
        //     now()->addSeconds(30),
        //     function () use ($user) {
        //         return $user->following->count();
        //     });

        return view('profiles.show', $user);
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id){
        $data = $this->service->find($id);
        $user = $this->userService->find($data['profile']->user_id);

        return view('profiles.edit', [
            'profile' => $data['profile'],
            'user' => $user['user'],
            'error' => $data['error'],
            'success' => $data['success'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $userId){

        $data = $this->service->update($request, $userId);

        return redirect()->route('profiles.show', $userId)->with([
            'profile' => $data['profile'], 
            'error' => $data['error'],
            'success' => $data['success'],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile){
        //
    }

    // public function deleteProfileImage(Request $request, $id){
    //     $image = $request->input('profileImage_id');
    //     $imagePath = public_path('profiles/'.$image);
        
    //     $response = $this->service->deleteProfileImage($id, $image, $imagePath);
        
    //     return response()->json([
    //         'user' => $response['user'], 
    //         'profile' => $response['profile'],
    //         'success' => $response['success'], 
    //         'error' => $response['error']
    //     ]);
    // }

    public function deleteProfileImage($userId){
        $user = $this->userService->find($userId);
        $profileImage = $user['user']->profile->profileImage;

        if (!$profileImage) {
            return response()->json([
                'error' => 'Profile image already null',
                'success' => null
            ]);
        }

        // $imagePath = public_path('profiles/' . $profileImage->path);

        // $response = $this->service->deleteProfileImage($user['user']->profile->id, $profileImage, $imagePath);

        // if($response['error']){
        //     return response()->json([
        //         'error' => $response['error'],
        //         'success' => null
        //     ]);
        // }

        // // Adiciona um parâmetro único ao URL da imagem
        // $noLogoImageUrl = asset('storage/profile_images/no-logo.png') . '?timestamp=' . time();

        // return response()->json([
        //     'user' => $response['user'],
        //     'profile' => $response['profile'],
        //     'success' => $response['success'],
        //     'error' => $response['error'],
        //     'noLogoImageUrl' => $noLogoImageUrl
        // ]);
        $response = $this->service->deleteProfileImage($user['user']->profile->id, $profileImage);

        if ($response['error']) {
            return response()->json([
                'error' => $response['error'],
                'success' => null
            ]);
        }
    
        return response()->json([
            'user' => $response['user'],
            'profile' => $response['profile'],
            'success' => $response['success'],
            'error' => $response['error']
        ]);

    }

    // public function follow(User $user){
    //     // return auth()->user()->following()->toggle($user->profile);
    // }

    // public function search(Request $request){
    //     $search = $request->get('search');
    //     $profiles = $this->service->search($search);

    //     return view('profiles.search', [
    //         'profiles' => $profiles['profiles'],
    //         'error' => $profiles['error'],
    //         'success' => $profiles['success'],
    //     ]);
    // }
}
