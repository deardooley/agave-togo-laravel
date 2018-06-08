<?php

namespace App\Http\Middleware;

use Agave\Client\API\TokensApi;
use Agave\Client\ApiException;
use Agave\Client\Configuration;
use Agave\Client\Model\RefreshToken;
use App\Exceptions\LinkedAccountException;
use App\Exceptions\LinkedAccountTokenException;
use App\Exceptions\UnlinkedAccountException;
use App\Models\Auth\SocialAccount;
use Auth;
use Closure;
use Log;

class TokenRefresh
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws UnlinkedAccountException
     * @throws LinkedAccountException
     * @throws LinkedAccountTokenException
     * @throws ApiException
     */
    public function handle($request, Closure $next)
    {

        $user = Auth::getUser();
        $provider = session()->get('socialite_provider') ?: 'agave';

        if ($user !== null) {

            /** @var SocialAccount $socialAccount */
            $socialAccount = SocialAccount::byUserProvider($user->id, $provider)->first();

            // if they have not linked accounts, throw exception
            if ($socialAccount == null) {
                Log::warning("User {$user->id} has not linked their Agave account. Rejecting proxy request to Agave API");

                throw new UnlinkedAccountException();
            } // if their linked account does not have an access token, throw exception
            else if (empty($socialAccount->token)) {
                Log::warning("User has not logged in with their Agave account. Rejecting proxy request to Agave API");
                throw new LinkedAccountException();
            }
            // if they have an access token, but the expiration timestamp is in the past,
            // check the refresh token and attempt to refresh before makign the call.
            else if (empty($socialAccount->expires_at) || $socialAccount->expires_at->isPast()) {
                Log::debug("Token is expired");

                // if the refresh token is missing, throw exception because we cannot refresh to get a valid token
                if (empty($socialAccount->refresh_token)) {
                    throw new LinkedAccountTokenException("User {$user->id}|{$socialAccount->provider_id}@{$provider} token is expired. No refresh token found. Please reauthenticate and try again.");
                }
                // we have a linked account, access token that we think is expired, and refresh token
                // let's try to refresh
                else {
                    Log::debug("User {$user->id}|{$socialAccount->provider_id}@{$provider} token is expired. Attempting refresh.");

                    // recycle the config from socialite as we can use the same api client to auth users
                    $agaveConfig = new Configuration([
                        'baseUrl' => rtrim(config('services.agave.instance_uri'), '/\s'),
                    ]);

                    $tokenApi = new TokensApi($agaveConfig);

                    /** @var RefreshToken $refreshToken */
                    try {
                        $refreshToken = $tokenApi->refresh($socialAccount->refresh_token,
                            config('services.agave.client_id'),
                            config('services.agave.client_secret'));

                        Log::debug("Successfully generated a refresh token for {$user->id}|{$socialAccount->provider_id}@{$provider}.");

                        // update the tokens and expiration dates in their linked account and
                        // save for future use.
                        $socialAccount->update([
                            'token' => $refreshToken->getAccessToken(),
                            'refresh_token' => $refreshToken->getRefreshToken(),
                            'expires_at' => Carbon::now()->addSeconds($refreshToken->getExpiresIn())
                        ]);
                    } catch (ApiException $e) {
                        throw new LinkedAccountException("Failed to refresh the user token. Please reauthenticate and try again.");
                    }
                }
            }
        }


        return $next($request);
    }
}
