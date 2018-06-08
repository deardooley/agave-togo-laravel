<?php

namespace Tests\Unit;

use Agave\Client\Configuration;
use Tests\TestCase;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model;
use App\Events\Backend\Auth\User\UserCreated;
use App\Events\Backend\Auth\User\UserUpdated;
use App\Repositories\Backend\Auth\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ThinKingMik\ApiProxy\Facades\ApiProxyFacade as Proxy;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    protected function setUp()
    {
        parent::setUp();

        $this->userRepository = $this->app->make(UserRepository::class);
        // We create a test-role because almost every test need one
        factory(Role::class)->create(['name' => 'test-role']);
    }

    /**
     * @test
     * @throws \Exception
     * @throws \ThinKingMik\ApiProxy\Exceptions\CookieExpiredException
     * @throws \ThinKingMik\ApiProxy\Exceptions\ProxyMissingParamException
     */
    public function testCanProxyGetRequest() {
        $config = Configuration::getDefaultConfiguration();

        $inputs = [
            'uri' => env('AGAVE_BASE_URL') . 'apps/v2',
            'access_token' => $config->getAccessToken(),
//            'refresh_token' => $config->getRefreshToken(),
//            'client_id' => $config->getClientKey(),
//            'client_secret' => $config->getClientKey()
        ];

        $resp = Proxy::makeRequest('GET', $inputs);

        $this->assertNotEmpty($resp);
        $this->assertArraySubset(["status" => "success"], $resp, "Response should have status attribute");
    }
}
