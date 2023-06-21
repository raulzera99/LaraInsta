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

interface ProfileServiceInterface{
    public function find($id);
    public function index();
    public function update(Request $request, $userId);
    public function destroy($id);
    public function deleteProfileImage($profileId, $profileImage);
}