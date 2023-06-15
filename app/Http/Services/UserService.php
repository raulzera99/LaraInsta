<?php

namespace App\Http\Services;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Services\UserServiceInterface;

// index - Show all 
// show - Show single 
// create - Show form to create new 
// store - Store new 
// edit - Show form to edit 
// update - Update 
// destroy - Delete  

class UserService implements UserServiceInterface{
    private $repository;

    //Constructor
    public function __construct(User $user){
        $this->repository = $user;
    }

    //Find User
    public function find($user){
        $data = $this->repository->find($user);

        if(!$data){
            return ([ 'error' => 'User not found'
                , 'success' => null
            ]);
        }

        return ([
            'user' => $data,
            'success' => 'User found successfully',
            'error' => null
        ]);
    }

    //Show All Users
    public function index(){
        $users = $this->repository->all();

        return ([
            'users' => $users,
            'error' => null,
            'success' => 'Users found successfully'
        ]);
    }

//Create New User
public function store(Request $request){
    $data = $request->validate($this->repository->rules());
    
    $data['password'] = bcrypt($data['password']);

    $user = $this->repository->create($data);

    //Create a new profile for the user
    $profile = new Profile([
        // 'user_id' => $user->id,
        'title' => $user->name,
        'description' => 'This is my description',
        'url' => 'https://www.example.com',
    ]);

    $profile->user_id = $user->id;
    $profile->save();
    $user->profile_id = $profile->id;
    $user->save();

    return ([ 
        'user' => $user,
        'profile' => $profile,
        'success' => 'User created successfully',
        'error' => null
    ]);
}


    //Update User
    public function update($user, $newData){
        $data = $this->repository->find($user);

        if($data['error']){
            return ([ 'error' => $data['error'],
                    'success' => null]);
        }

        $data->update($newData);

        return ([
            'success' => 'User updated successfully',
            'user' => $data['user'],
            'error' => null
        ]);
    }

    //Delete User
    public function destroy($user){
        $data = $this->repository->find($user);

        if(!$data){
            return ([ 'error' => 'User not found',
                'success' => null]);
        }

        $data->delete();

        return ([
            'success' => 'User deleted successfully',
            'error' => null	
        ]);
    }

    //Get Roles
    public function getRoles(){
        return ([
            'roles' => $this->repository->roles(),
            'error' => null,
            'success' => 'Roles found successfully'
        ]);
    }

  

}