<?php

namespace App\Http\Service;

use App\Models\User;
use App\Http\Service\UserServiceInterface;

class UserService implements UserServiceInterface{
    private $repository;

    public function __construct(User $user){
        $this->repository = $user;
    }

    public function search($search, $perPage){

        $query = User::query();

        $users = $this->repository->
        where(
            function($query) use($search) {
                if(!$search){
                    $query->where('name', 'like', $search);
                    $query->orWhere('email', 'like', '%'. implode($search) .'%');
                }
            }    
        )->paginate($perPage);

        $users = $query->get();

        return ([
            'users' => $users
        ]);
    }

    //Show All Users
    public function index(){

        // $users = $this->repository->
        // where(function($query) use($search) {
        //         if(!$search){
        //             $query->where('name', 'like', $search);
        //             $query->orWhere('email', 'like', '%'. implode($search) .'%');
        //         }
        //     }    
        // )->paginate($item);
        
        $users = $this->repository->all();

        return ([
            'users' => $users,
            'error' => null,
            'success' => 'Users found successfully'
        ]);
    }

    //Create New User
    public function create($data){
        $user = $this->repository->create($data);

        return ([
            'success' => 'User created successfully',
            'error' => null,
            'user' => $user
        ]);
    }

    public function update($user, $newData){
        $data = $this->repository->find($user);

        if($data['error']){
            return ([ 'error' => $data['error'],
                    'success' => null]);
        }

        $data->update($newData);

        return ([
            'success' => 'User updated successfully',
            'user' => $data,
            'error' => null
        ]);
    }

    public function find($user){
        $data = $this->repository->find($user);

        if(!$data){
            return ([ 'error' => 'User not found']);
        }

        return ([
            'user' => $data,
            'success' => 'User found successfully',
            'error' => null
        ]);
    }

    public function delete($user){
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

    public function deleteLogo($id, $logo, $logoPath){
        $data = $this->repository->find($id);

        if(!$data){
            return ([ 'error' => 'User not found',
                'success' => null]);
        }

        if(file_exists($logoPath) == false || is_file($logoPath) == false || empty($logo)){
            return ([ 'error' => 'Logo not found',
                'success' => null]);
        }

        $data->update([
            'logo' => null
        ]);

        unlink($logoPath);
        $logo->delete();

        return ([
            'success' => 'Logo deleted successfully',
            'error' => null
        ]);
    }

  

}