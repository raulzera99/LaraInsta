<?php

namespace App\Http\Controllers;

//use App\Models\User;
use console;
use Illuminate\Http\Request;
use App\Http\Services\UserServiceInterface;

// index - Show all 
// show - Show single 
// create - Show form to create new 
// store - Store new 
// edit - Show form to edit 
// update - Update 
// delete - Show form to delete
// destroy - Delete  

class UserController extends Controller{
    private $service;

    //Constructor  
    public function __construct(UserServiceInterface $userService){
        $this->service = $userService;
    }


    //Show All Users
    public function index(){
        $data = $this->service->index();

        return view('users.index', [
            'users' => $data['users'],
            'error' => $data['error'],
            'success' => $data['success'],
        ]);
    }

    //Show Single User
    public function show($id){
        $data = $this->service->find($id);

        if($data['error']){
            return redirect()->back()
            ->with([
                'error' => $data['error'], 
                'success' => null,
                'user' => null
            ]);
        }

        return ([ 'user' => $data['user'],
            'success' => $data['success'],
            'error' => $data['error']
        ]);
    }

    //Show Form to Create New User
    public function create(){
        return view('register');
    }

    //Create New User
    public function store(Request $request){

        $data = $this->service->store($request);

        return view('users.index', [
            'users' => $data['users'],
            'error' => $data['error'],
            'success' => $data['success'],
        ]);
    }

    //Show Form to Edit User
    public function edit($user){
        $data = $this->service->find($user);

        return view('users.edit', [
            'user' => $data['user'],
            'error' => $data['error'],
            'success' => $data['success'],
        ]);
    }

    //Update User
    public function update($user, $newData){
        $data = $this->service->update($user, $newData);

        return view('users.index', [
            'users' => $data['users'],
            'error' => $data['error'],
            'success' => $data['success'],
        ]);
    }

    //Show Form to Delete User
    public function delete($user){
        $data = $this->service->find($user);

        return view('users.delete', [
            'user' => $data['user'],
            'error' => $data['error'],
            'success' => $data['success'],
        ]);
    }

    //Delete User
    public function destroy($user){
        $data = $this->service->destroy($user);

        return view('users.index', [
            'users' => $data['users'],
            'error' => $data['error'],
            'success' => $data['success'],
        ]);
    }

    
}

