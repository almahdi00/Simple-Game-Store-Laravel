<?php
namespace App\Providers;

use App\Models\Game;
use App\Models\Transaction;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('play', function ($user, Game $game) {
            return Transaction::where('user_id', $user->id)
                            ->where('game_id', $game->id)
                            ->where('status', 'approved')
                            ->exists();
        });
    }
}