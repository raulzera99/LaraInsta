<?php 

namespace App\Http\Services;

use App\Models\Comment;
use Illuminate\Http\Request;

// index - Show all
// show - Show single
// create - Show form to create new
// store - Store new
// edit - Show form to edit
// update - Update
// destroy - Delete

interface CommentServiceInterface{
    public function find($id);
    public function index();
    public function store(Request $request);
    // public function update(Request $request, $id);
    public function destroy($id);
}