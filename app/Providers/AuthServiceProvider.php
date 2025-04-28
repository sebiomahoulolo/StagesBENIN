<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\MessagePost;
use App\Models\MessageComment;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Define gates for messagerie-sociale
        Gate::define('create-post', function (User $user) {
            return $user->isAdmin() || $user->isRecruteur();
        });

        Gate::define('update-post', function (User $user, MessagePost $post) {
            return $user->isAdmin() || ($user->id === $post->user_id && $user->isRecruteur());
        });

        Gate::define('delete-post', function (User $user, MessagePost $post) {
            return $user->isAdmin() || ($user->id === $post->user_id && $user->isRecruteur());
        });

        Gate::define('delete-comment', function (User $user, MessageComment $comment) {
            return $user->isAdmin() || $user->id === $comment->user_id;
        });
    }
}
