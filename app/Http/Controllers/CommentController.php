<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Services\CommentServiceInterface;

class CommentController extends Controller{
    private $service;

    //Constructor
    public function __construct(CommentServiceInterface $commentService){
        $this->service = $commentService;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(){
        $data = $this->service->index();

        return ([
            'comments' => $data['comments'],
            'error' => $data['error'],
            'success' => $data['success'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request){
        $data = $this->service->store($request);

        return ([
            'comment' => $data['comment'],
            'error' => $data['error'],
            'success' => $data['success'],
        ]);
    }

    /**
     * Display the specified resource.
     */
    // public function show(Comment $comment)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Comment $comment)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateCommentRequest $request, Comment $comment)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment){
        $data = $this->service->destroy($comment);

        return ([
            'comment' => $data['comment'],
            'error' => $data['error'],
            'success' => $data['success'],
        ]);
    }
}
