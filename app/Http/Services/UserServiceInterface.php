<?php

namespace App\Http\Services;

use Illuminate\Http\Request;

// index - Show all 
// show - Show single 
// create - Show form to create new 
// store - Store new 
// edit - Show form to edit 
// update - Update 
// destroy - Delete  

interface UserServiceInterface{
    public function find($id);
    public function index();
    public function store(Request $request);
    public function update($data, $id);
    public function destroy($id);
    public function getRoles();
}