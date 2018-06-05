<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

/**
 * Class BroadcastServiceProvider.
 */
class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes([ 'middleware' => [ 'web', 'jwt.auth' ] ]);

        require base_path('routes/channels.php');

        // Verifies the authenticated user has access to the channel by verifying that the user's linked account
        // has the provider and provider_id corresponding to the channel name. Since these are unique across all
        // accounts, this is a valid check.
        Broadcast::channel('*.user.*', function (User $user, $provider, $providerId) {
            Log::debug("Validating user can access channel {$provider}.user.{$providerId}");
            $socialAccount = $user->socialAcconts()->where('provider', $provider)->where('provider_id', $providerId)->first();

            if ($socialAccount) {
                return true;
            }
            else {
                Log::debug("Failed to authenticate user {$user->username} to channel {$provider}.user.{$providerId}");
            }
        });

    }
}
