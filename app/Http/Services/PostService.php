<?php

namespace App\Http\Services;

use App\Models\Post;
use App\Models\Media;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;


class PostService implements PostServiceInterface{
    private $repository;

    //Constructor
    public function __construct(Post $postModel){
        $this->repository = $postModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(){
        $posts = $this->repository->all();

        return [
            'posts' => $posts,
            'error' => false,
            'success' => true,
        ];
    }

    public function self(){
        $user = auth()->user();

        if($user){
            return [
                'user' => $user,
                'error' => false,
                'success' => true,
            ];
        }
        else{
            return [
                'user' => null,
                'error' => false,
                'success' => true,
            ];
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        // $data = $request->validate($this->repository->rules());

        // $user = auth()->user();

        // $data['profile_id'] = $user->profile->id;

        // $data['likes'] = 0;

        // $media = $request->file('media');

        // if($media){
        //     $path = $media->store('posts', 'public');

        //     $data['media'] = $path;
        // }
        
        // $post = auth()->user()->profile()->posts()->create($data);

        // return [
        //     'post' => $post,
        //     'error' => false,
        //     'success' => true,
        // ];
        
        $data = $request->validate($this->repository->rules());

        $user = auth()->user();

        if(!$user->profile){
            $profile = new Profile();
            $profile->user()->associate($user);
            $profile->save();
        }

        $post = new Post();
        $post->caption = $data['caption'];
        $post->profile()->associate($user->profile);
        $post->save();

        $data = $request->validate([
            'images' => 'required|array',
            'images.*' => ['image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
        ]);


        foreach ($data['images'] as $index => $image) {
            $filename = $index . '_' . time() . '.' . $request->file('images')[$index]->extension();
            $image->storeAs('public/posts', $filename);

            $media = new Media();
            $media->path = $filename;
            $post->medias()->save($media);

            //$request->logo->move(public_path('logos'), $logoName);
            // $request->file('logo')->storeAs('/public/logos', $logoName);
            // storage/app/files/file.pdf
        }

        return [
            'user' => $user,
            'post' => $post,
            'error' => false,
            'success' => true,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function find($id){
        $data = $this->repository->find($id);

        if($data){
            return [
                'post' => $data,
                'error' => false,
                'success' => 'Post found!',
            ];
        }
        else{
            return [
                'post' => null,
                'error' => true,
                'success' => 'Post not found!',
            ];
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($data, $id){
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        
    }

    public function like($id){
        if (!auth()->check()) {
            return [
                'post' => null,
                'error' => true,
                'success' => 'You must be logged in to like a post!',
            ];
        }

        $post = $this->repository->find($id);

        if (!$post) {
            return [
                'post' => null,
                'error' => true,
                'success' => 'Post not found!',
            ];
        }

        // Verifica se o usuário já deu like no post
        $user = auth()->user();
        $hasLiked = $post->likes()->where('user_id', $user->id)->exists();

        if ($hasLiked) {
            // Remove o like
            $post->likes()->detach($user->id);
            $post->likes_count -= 1;
            $post->save();

            return [
                'post' => $post,
                'error' => false,
                'success' => 'Post unliked!',
            ];
        } else {
            // Adiciona o like
            $post->likes()->attach($user->id);
            $post->likes_count += 1;
            $post->save();

            return [
                'post' => $post,
                'error' => false,
                'success' => 'Post liked!',
            ];
        }
    }

}