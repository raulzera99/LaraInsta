<?php

namespace App\Http\Services;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Services\CommentServiceInterface;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

// index - Show all 
// show - Show single 
// create - Show form to create new 
// store - Store new 
// edit - Show form to edit 
// update - Update 
// destroy - Delete  

class CommentService implements CommentServiceInterface{
    use AuthenticatesUsers;

    private $repository;

    //Constructor
    public function __construct(Comment $comment){
        $this->repository = $comment;
    }

    //Find Comment
    public function find($comment){
        $data = $this->repository->find($comment);

        if(!$data){
            return ([ 'error' => 'Comment not found'
                , 'success' => null
            ]);
        }

        return ([
            'comment' => $data,
            'success' => 'Comment found successfully',
            'error' => null
        ]);
    }

    //Show All Comments
    public function index(){
        $comments = $this->repository->all();

        return ([
            'comments' => $comments,
            'error' => null,
            'success' => 'Comments found successfully'
        ]);
    }

    // //Create New Comment
    // public function store(Request $request){
    //     if(!auth()->check()){
    //         return ([ 'error' => 'User not logged in'
    //             , 'success' => null
    //         ]);
    //     }

    //     if(!Post::find($request->post_id)){
    //         return ([ 'error' => 'Post not found'
    //             , 'success' => null
    //         ]);
    //     }

    //     $data = $request->validate($this->repository->rules());

    //     $comment = new Comment();

    //     $comment->content = $data['content'];

    //     $comment->post = Post::find($request->post_id);

    //     $comment->profile = $comment->post->profile;

    //     $data = $this->repository->create($comment->toArray());

    //     if(!$data){
    //         return ([ 'error' => 'Comment not created'
    //             , 'success' => null
    //         ]);
    //     }

    //     return ([
    //         'comment' => $data,
    //         'success' => 'Comment created successfully',
    //         'error' => null
    //     ]);
    // }

    public function store(Request $request){
        if (!auth()->check()) {
            return [
                'error' => 'User not logged in',
                'success' => null,
            ];
        }

        $post = Post::find($request->post_id);
        if (!$post) {
            return [
                'error' => 'Post not found',
                'success' => null,
            ];
        }

        $data = $request->validate($this->repository->rules());

        $comment = new Comment();
        $comment->content = $data['content'];
        $comment->post()->associate($post);
        $comment->profile()->associate($post->profile);
        $comment->save();

        return [
            'comment' => $comment,
            'success' => 'Comment created successfully',
            'error' => null,
        ];
    }

    //Destroy Comment
    public function destroy($comment){
        $data = $this->repository->find($comment);

        if(!$data){
            return ([ 'error' => 'Comment not found'
                , 'success' => null
            ]);
        }

        $data->delete();

        return ([
            'comment' => $data,
            'success' => 'Comment deleted successfully',
            'error' => null
        ]);
    }

}