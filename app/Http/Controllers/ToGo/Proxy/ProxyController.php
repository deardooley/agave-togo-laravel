<?php

namespace App\Http\Controllers\ToGo\Proxy;

use Agave\Client\API\TokensApi;
use Agave\Client\Configuration;
use Agave\Client\Model\RefreshToken;
use Agave\Client\Model\SingleClientResponse;
use App\Http\Controllers\Controller;
use App\Models\Auth\SocialAccount;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use ThinKingMik\ApiProxy\Exceptions\CookieExpiredException;
use ThinKingMik\ApiProxy\Exceptions\ProxyMissingParamException;
use ThinKingMik\ApiProxy\Proxy;

/**
 * Class DashboardController.
 */
class ProxyController extends Controller
{
    /**
     * Attempty proxy using Larave API Proxy module
     * @return Response
     * @throws AuthorizationException
     * @throws AuthenticationException
     */
    public function proxy(Request $request)
    {
        $user = Auth::getUser();

        if ($user == null && session()->get('provider')) {
            $provider = session()->get('provider');

            /** @var SocialAccount $socialAccount */
            $socialAccount = SocialAccount::byUserProvider($user->id, $provider)->first();

            // if they have not linked accounts, throw exception
            if ($socialAccount == null) {
                throw new AuthorizationException("User has not logged in with their agave account.");
            }
            // if their linked account does not have an access token, throw exception
            else if (empty($socialAccount->access_token)) {
                throw new AuthorizationException("User has not logged in with their agave account.");
            }
            // if they have an access token, but the expiration timestamp is in the past,
            // check the refresh token and attempt to refresh before makign the call.
            else if (empty($socialAccount->expiresAt) || $socialAccount->expiresAt->before(Carbon::now())) {

                // if the refresh token is missing, throw exception because we cannot refresh to get a valid token
                if (empty($socialAccount->refresh_token)) {
                    throw new AuthorizationException("No refresh token found. Please reauthenticate and try again.");
                }
                // we have a linked account, access token that we think is expired, and refresh token
                // let's try to refresh
                else {

                    Log::debug("User {$user->username}|{$socialAccount->provider_id}@{$provider}token is expired. Attempting refresh.");

                    // recycle the config from socialite as we can use the same api client to auth users
                    $agaveConfig = new Configuration([
                        'baseUrl' => config('services.agave.instance_uri'),
                    ]);

                    $tokenApi = new TokensApi($agaveConfig);

                    /** @var RefreshToken $refreshToken */
                    $refreshToken = $tokenApi->refresh($socialAccount->refresh_token,
                        config('services.agave.client_id'),
                        config('services.agave.client_secret'));

                    // if the refresh worked, update the tokens and expiration dates in their linked account and
                    // save for future use.
                    if ($refreshToken) {
                        Log::debug("Successfully generated a refresh token for {$user->username}|{$socialAccount->provider_id}@{$provider}.");

                        $socialAccount->update([
                            'access_token' => $refreshToken->getAccessToken(),
                            'refresh_token' => $refreshToken->getRefreshToken(),
                            'expires_at' => Carbon::now()->addSeconds($refreshToken->getExpiresIn())
                        ]);
                    }
                    else {
                        throw new AuthorizationException("Failed to refresh the user token. Please reauthenticate and try again.");
                    }
                }
                // refresh the token
            }


//        try {

            // We believe we have a valid user with what looks like a valid set of keys. Let's try to make the call.

            $agavePath = str_replace("/togo/proxy", "", $request->path());
            $inputs = $request->all();
            // insert the target url so the proxy knows where to send the request
            $inputs['uri'] = config('services.agave.instance_uri') . '/' . $agavePath;
            // insert the auth token to the inputs. This will get translated into the oauth header before the call is made.
            $inputs['access_token'] = $socialAccount->access_token;

            return Proxy::makeRequest(Request::method(), $inputs);
//        } catch (CookieExpiredException $e) {
//        } catch (ProxyMissingParamException $e) {
//        } catch (\Exception $e) {
//        }
        }
        else {
            throw new AuthenticationException("User login required.");
        }
    }

    /**
     * Attempt alternative proxy using guzzle directly
     * @param Request $request
     * @return $this
     */
    public function rawProxy(Request $request)
    {
        // extract the path from the request
        $agavePath = str_replace("/togo/proxy", "", $request->path());
        $inputs = $request->all();
        $url = config('services.agave.instance_uri') . '/' . $agavePath;


        // Instantiate an instance of the GuzzleHttp Client
        /** @var Client $client */
        $client = new Client();

        //--------------------
        if (!isset($curl_timeout))
            $curl_timeout = 30;
        // Get request attributes
        $headers = $request->header();
        $method = $request->getMethod();

        // Check that we have a URL
        if (!$url)
            http_response_code(400) and exit("X-Proxy-Url header missing");

        // Check that the URL looks like an absolute URL
        if (!parse_url($url, PHP_URL_SCHEME))
            http_response_code(403) and exit("Not an absolute URL: $url");

        // Remove ignored headers and prepare the rest for resending
        $ignore = ['Cookie', 'Host', 'X-Proxy-URL'];
        $headers = array_diff_key($headers, array_flip($ignore));
        $body = "";

        // Method specific options
        switch ($method) {
            case 'GET':
                break;
            case 'PUT':
            case 'POST':
            case 'DELETE':
            default:
                // Capture the post body of the request to send along
                $body = $request->getContent(true);
                break;
        }

        /** @var ResponseInterface $response */
        $response = null;
        try {
            //Make the HTTP request
            $response = $client->request($method, $url, ['headers' => $headers, 'body' => $body, 'decode_content' => false]);

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
            }
        } catch (\Throwable $e) {
            echo $e;
            echo "=================";
            if (method_exists($e, 'hasResponse') && $e->hasResponse() ) {
                $response = $e->getResponse();
            }
        }

        // Remove any existing headers
        header_remove();

        //Print all the headers except for "Transfer-Encoding" because chunked responses will end up failing.
        if ($response) {
            foreach ($response->getHeaders() as $key => $value) {
                if ($key != "Transfer-Encoding") {
                    response()->headers->set("$key: $value[0]");
                }
            }

            // Return the response code and bocy
            return response()->setStatusCode($response->getStatusCode())
                ->setContent($response->getBody());
        }
        else {
            // return an error response describing the failed remote request attempt
            return response()->setStatusCode(500)
                ->setContent([
                'status' => 'error',
                'message' => 'An internal server error occurred preventing the request from being made.'
            ]);

        }
    }
}
