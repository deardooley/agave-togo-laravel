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
use ThinKingMik\ApiProxy\Exceptions\ProxyException;
use ThinKingMik\ApiProxy\Exceptions\ProxyMissingParamException;
use ThinKingMik\ApiProxy\Facades\ApiProxyFacade as Proxy;

/**
 * Class DashboardController.
 */
class ProxyController extends Controller
{
    /**
     * Attempty proxy using Larave API Proxy module
     * @param Request $request
     * @param string $apiPath actual api path relative to the route mapped to this controller
     * @return Response
     * @throws AuthorizationException
     * @throws CookieExpiredException
     * @throws ProxyMissingParamException
     * @throws \Agave\Client\ApiException
     * @throws \Exception
     */
    public function proxy(Request $request, $apiPath)
    {
        $user = Auth::getUser();
        $provider = session()->get('socialite_provider') ;
        $provider = $provider ?: 'agave';

        /** @var SocialAccount $socialAccount */
        $socialAccount = SocialAccount::byUserProvider($user->id, $provider)->first();
//

//        if ($user !== null && $provider !== null) {
//
//            /** @var SocialAccount $socialAccount */
//            $socialAccount = SocialAccount::byUserProvider($user->id, $provider)->first();
//
//            Log::debug($socialAccount->toArray());
//            // if they have not linked accounts, throw exception
//            if ($socialAccount == null) {
//                throw new AuthorizationException("User has not linked their agave account.");
////                view('json.index', ['status' => 'error', 'message' => "User has not linked their agave account.",'result' => []]);
//            }
//            // if their linked account does not have an access token, throw exception
//            else if (empty($socialAccount->token)) {
////                return view('json.index', ['status' => 'error', 'message' => "User has not logged in with their agave account.",'result' => []]);
//                throw new AuthorizationException("User has not logged in with their agave account.");
//            }
//            // if they have an access token, but the expiration timestamp is in the past,
//            // check the refresh token and attempt to refresh before makign the call.
//            else if (empty($socialAccount->expires_at) || $socialAccount->expires_at->isPast()) {
//                Log::debug("Token is expired");
//
//                // if the refresh token is missing, throw exception because we cannot refresh to get a valid token
//                if (empty($socialAccount->refresh_token)) {
////                    view('json.index', ['status' => 'error', 'message' => "No refresh token found. Please reauthenticate and try again.",'result' => []]);
//                    throw new AuthorizationException("No refresh token found. Please reauthenticate and try again.");
//                }
//                // we have a linked account, access token that we think is expired, and refresh token
//                // let's try to refresh
//                else {
//                    Log::debug("User {$user->id}|{$socialAccount->provider_id}@{$provider}token is expired. Attempting refresh.");
//
//                    // recycle the config from socialite as we can use the same api client to auth users
//                    $agaveConfig = new Configuration([
//                        'baseUrl' => rtrim(config('services.agave.instance_uri'), '/\s'),
//                    ]);
//
//                    $tokenApi = new TokensApi($agaveConfig);
//
//                    /** @var RefreshToken $refreshToken */
//                    $refreshToken = $tokenApi->refresh($socialAccount->refresh_token,
//                        config('services.agave.client_id'),
//                        config('services.agave.client_secret'));
//
//                    // if the refresh worked, update the tokens and expiration dates in their linked account and
//                    // save for future use.
//                    if ($refreshToken) {
//
//                        Log::debug("Successfully generated a refresh token for {$user->id}|{$socialAccount->provider_id}@{$provider}.");
//
//                        $socialAccount->update([
//                            'token' => $refreshToken->getAccessToken(),
//                            'refresh_token' => $refreshToken->getRefreshToken(),
//                            'expires_at' => Carbon::now()->addSeconds($refreshToken->getExpiresIn())
//                        ]);
//                    }
//                    else {
////                        view('json.index', ['status' => 'error', 'message' => "Failed to refresh the user token. Please reauthenticate and try again.",'result' => []]);
//                        throw new AuthorizationException("Failed to refresh the user token. Please reauthenticate and try again.");
//                    }
//                }
//            }

        try {
            // We believe we have a valid user with what looks like a valid set of keys. Let's try to make the call.

            $inputs = $request->all();
            // insert the target url so the proxy knows where to send the request
            $inputs['uri'] = config('services.agave.instance_uri') . '/' . $apiPath;
            // insert the auth token to the inputs. This will get translated into the oauth header before the call is made.
            $inputs['access_token'] = $socialAccount->token;

            if ($request->acceptsHtml()) {
                /** @var Response $response */
                $response = Proxy::makeRequest($request->method(), $inputs);
                $response->headers->set('Content-Type', 'text/html');

                return $response;
            }
            else {
                return Proxy::makeRequest($request->method(), $inputs);
            }
        } catch (\Exception | \Throwable $e) {
            throw new ProxyException("An error occurred while proxying a request to {$apiPath}");
            //)return view('json.index', ['status' => 'error', 'message' => $e->getMessage(), 'result' => $e->getTrace()]);
        }
//        }
//        else {
//            return view('json.index', ['status' => 'error', 'message' => "User login required.", 'result' => ['user' => $user->toArray(), 'provider' => $provider, 'session' => session()]]);
////            throw new AuthenticationException("User login required.");
//        }
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
