<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Services\PostService;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Services\PostServiceInterface;

class PostController extends Controller{
    private $service;

    //Constructor
    public function __construct(PostServiceInterface $postService){
        $this->service = $postService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(){
        $data = $this->service->index();

        return view('posts.index', [
            'posts' => $data['posts'],
            'error' => $data['error'],
            'success' => $data['success'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        if(auth()->user()){
            return view('posts.create');   
        }
        else{
            return redirect()->route('login');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $data = $this->service->store($request);

        return redirect()->route('posts.show', $data['post']->id);
        // return redirect()->route('posts.index');

    }

    /**
     * Display the specified resource.
     */
    public function show($id){
        $data = $this->service->find($id);

        return view('posts.show', [
            'post' => $data['post'],
            'error' => $data['error'],
            'success' => $data['success'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
