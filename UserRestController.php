<?php

namespace App\Http\Controllers\Api;

use console;
//use App\Models\User;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\UserModel;
use App\Http\Service\UserService;
use App\Http\Controllers\Controller;

class UserRestController extends Controller
{
    private $service;

    //Constructor  
    public function __construct(UserService $userService){
        $this->service = $userService;
    }
    
    //Show All Users
    public function index(Request $request){
        $search = $request->input('search');
        $perPage = $request->input('perPage') ?? 5;
        // $pageSize = [5,10,15,20];
        if ($search){
            $users = $this->service->search($search, $perPage );
        }
        else{
            $users = $this->service->index();
        }

        
        return response()->json( [
            'users' => $users['users'],
            'error' => $users['error'],
            'success' => $users['success'],
            'perPage' => $perPage,
        ]);
    }
    
   
    //Show Single User
    public function show($id){
        $data = $this->service->find($id);

        if($data['error']){
            return response()->json([
                'error' => $data['error'],
                'success' => null,
                'user' => null
            ],404);	
        }

        return response()->json([
            'user' => $data['user'],
            'success' => $data['success'],
            'error' => $data['error'],
        ],200);
    }

   
    //Create New User
    public function store(User $userModel, UserModel $request){
        
        $userModel = $request->all();

        // $formFields = $request->validate([
        //     'name' => ['required','min:3'],
        //     'email' => ['required', 'email', Rule::unique('users', 'email')],
        //     'password' => 'required|min:6|confirmed'
        // ]);

        // $formFields['password'] = bcrypt($formFields['password']);

        //Create User

        $user = $this->service->create($userModel);

        //Log User In
        // auth()->login($userModel['user']);

        return response()->json([
            'user' => $user['user'],
            'success' => $user['success'],
            'error' => $user['error'],
        ],200);
    }

    //Storage New User Manualy
    public function storeManually(Request $request){
        $formFields = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 
            Rule::unique('users', 'email'), 
            'max:100', 'string'],
            'logo' => ['image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
        ]);

        $logoName = time().'.'.$request->logo->extension();
        
        //$request->logo->move(public_path('logos'), $logoName);
        $request->file('logo')->storeAs('/public/logos', $logoName);
        // storage/app/files/file.pdf

        //Store Image URL
        $formFields['email'] = $request->email;
        $formFields['name'] = $request->name;
        $formFields['logo'] = $logoName;

        //Create User
        $user = $this->service->create($formFields);

        return redirect()->route('users.index', [
            'success' => $user['success'],
            'error' => $user['error'],
            'user' => $user
        ]);
    }


    //Log User Out
    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'User Logged Out!');
    }

    //Authenticate User
    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();

            return redirect('/')->with('message', 'User Logged In!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function update(User $userModel, Request $request , $user){
        $formFields = $request->json()->all();

        $userModel->name = $formFields['name'];
        $userModel->email = $formFields['email'];

        //Update User
        $data = $this->service->update($userModel, $user);

        return response()->json( [
            'success' => $data['success'],
            'error' => $data['error'],
            'user' => $data['user'],
            'status' => 'ok'
        ],200);
        
    }


    public function destroy($user){
        $data = $this->service->delete($user);

        if($data['error']){
            return response()->json([
                'error' => $data['error'],
                'success' => null,
                'user' => null
            ],404);
        }

        return response()->json([
            'user' => $data['user'],
            'success' => $data['success'],
            'error' => $data['error'],
        ],200);
    }


    public function deleteLogo(Request $request, $id){
        $logo = $request->input('logo_id');
        $logoPath = public_path('logos/'.$logo);
        
        $response = $this->service->deleteLogo($id, $logo, $logoPath);
        
        return response()->json([
            'success' => $response['success'], 
            'error' => $response['error']
        ]);
    }
    
    
}

