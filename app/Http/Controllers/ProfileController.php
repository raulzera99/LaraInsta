<?php

namespace App\Http\Controllers;

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

    public function self(){
        $user = $this->service->self();
        //TODO: Fix this
        // if($user['error']){
        //     return redirect('/')->with('error', $user['error']);
        // }

        // $follows = (auth()->user()) ? $user['user']->profile()->following() : false;

        // $postCount = Cache::remember(
        //     'count.posts.' . $user->id,
        //     now()->addSeconds(30),
        //     function () use ($user) {
        //         return $user->posts->count();
        //     });

        // $followersCount = Cache::remember(
        //     'count.followers.' . $user->id,
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

        // return view('profiles.index', compact('user', 'follows', 'postCount', 'followersCount', 'followingCount'));

        return view('profiles.show', [
            'user' => $user['user'],
            'error' => $user['error'],
            'success' => $user['success'],
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

    public function deleteProfileImage(Request $request, $id){
        $image = $request->input('profileImage-id');
        $imagePath = public_path('profiles/'.$image);
        $profile = $this->userService->find($id);
        
        $response = $this->service->deleteProfileImage($profile->id, $image, $imagePath);
        
        return response()->json([
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