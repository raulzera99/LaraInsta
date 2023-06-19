<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Requests\UserModel;
use Illuminate\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Services\UserServiceInterface;

// index - Show all 
// show - Show single 
// create - Show form to create new 
// store - Store new 
// edit - Show form to edit 
// update - Update 
// delete - Show form to delete
// destroy - Delete  

class UserRestController extends Controller{
    private $service;

    //Constructor  
    public function __construct(UserServiceInterface $userService){
        $this->service = $userService;
    }


    //Show All Users
    public function index(){
        $data = $this->service->index();

        return response()->json([
            'users' => $data['users'],
            'error' => $data['error'],
            'success' => $data['success'],
        ], 200);
    }

    //Show Single User
    public function show($id){
        $data = $this->service->find($id);

        if($data['error']){
            return response()->json([
                'error' => $data['error'], 
                'success' => null,
                'user' => null
            ], 404);
        }

        return response()->json([ 
            'user' => $data['user'],
            'success' => $data['success'],
            'error' => $data['error']
        ], 200);
    }

    //Create New User
    public function store(UserModel $request){
        // $newData = $request->all();
        // $user->password = bcrypt($newData['password']);
        // $user->name = $newData['name'];
        // $user->email = $newData['email'];

        $data = $this->service->store($request);

        return response()->json([
            'user' => $data['user'],
            'error' => $data['error'],
            'success' => $data['success'],
        ], 201);
    }

    //Update User
    public function update(UserModel $request, $id){

        $newData = $request->json()->all();

        $data = $this->service->update($newData, $id);

        return response()->json( [
            'users' => $data['users'],
            'error' => $data['error'],
            'success' => $data['success'],
        ]);
    }

    //Delete User
    public function destroy($id){
        $data = $this->service->destroy($id);

        return response()->json( [
            'users' => $data['users'],
            'error' => $data['error'],
            'success' => $data['success'],
        ]);
    }
    
}

