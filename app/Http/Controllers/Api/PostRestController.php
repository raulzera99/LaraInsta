<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Services\PostService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Services\PostServiceInterface;

//     Route::any('/index', [MediaRestController::class, 'index']);
//     Route::any('/{media}', [MediaRestController::class, 'show']);
//     Route::post('/store', [MediaRestController::class, 'store']);
//     Route::put('/{media}', [MediaRestController::class, 'update']);
//     Route::delete('/{media}', [MediaRestController::class, 'destroy']);

class PostRestController extends Controller{
    private $service;

    //Constructor
    public function __construct(PostServiceInterface $postService){
        $this->service = $postService;
    }

    public function index(){
        $posts = $this->service->index();

        return response()->json([
            'posts' => $posts['posts'],
            'error' => $posts['error'],
            'success' => $posts['success'],
        ], 200);
    }

    public function show(Post $post){
        $data = $this->service->find($post->id);

        if($data['error']){
            return response()->json([
                'error' => $data['error'], 
                'success' => null,
                'post' => null
            ], 404);
        }

        return response()->json([ 
            'post' => $data['post'],
            'success' => $data['success'],
            'error' => $data['error']
        ], 200);
    }

    public function store(StorePostRequest $request){
        $data = $this->service->store($request());

        if($data['error']){
            return response()->json([
                'error' => $data['error'], 
                'success' => null,
                'post' => null
            ], 404);
        }

        return response()->json([ 
            'post' => $data['post'],
            'success' => $data['success'],
            'error' => $data['error']
        ], 200);
    }

    public function update(UpdatePostRequest $request, Post $post){
        $data = $this->service->update($request->all(), $post->id);

        if($data['error']){
            return response()->json([
                'error' => $data['error'], 
                'success' => null,
                'post' => null
            ], 404);
        }

        return response()->json([ 
            'post' => $data['post'],
            'success' => $data['success'],
            'error' => $data['error']
        ], 200);
    }

    public function destroy(Post $post){
        $data = $this->service->destroy($post->id);

        if($data['error']){
            return response()->json([
                'error' => $data['error'], 
                'success' => null,
                'post' => null
            ], 404);
        }

        return response()->json([ 
            'post' => $data['post'],
            'success' => $data['success'],
            'error' => $data['error']
        ], 200);
    }


}
