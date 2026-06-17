<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Appeal;

use App\Policies\Post\PostPolicy;
use App\Policies\Tag\TagPolicy;
use App\Policies\Appeal\AppealPolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Post::class => PostPolicy::class,
        Tag::class => TagPolicy::class,
        Appeal::class =>  AppealPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
