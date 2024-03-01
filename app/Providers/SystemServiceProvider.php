<?php

namespace App\Providers;

use App\Http\Services\PostService;
use App\Http\Services\UserService;
use App\Http\Services\CommentService;
use App\Http\Services\ProfileService;
use Illuminate\Support\ServiceProvider;
use App\Http\Services\PostServiceInterface;
use App\Http\Services\UserServiceInterface;
use App\Http\Services\CommentServiceInterface;
use App\Http\Services\ProfileServiceInterface;


class SystemServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(ProfileServiceInterface::class, ProfileService::class);
        $this->app->bind(PostServiceInterface::class, PostService::class);
        $this->app->bind(CommentServiceInterface::class, CommentService::class);
    }
    
}
