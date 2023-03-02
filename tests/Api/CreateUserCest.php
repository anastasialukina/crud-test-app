<?php


namespace Tests\Api;

use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\Support\ApiTester;

class CreateUserCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function testLoginIsSuccess(ApiTester $I): void
    {
        $I->wantToTest('Login is success');

        // send credential data
        $I->sendPOST('/api/login', ['email' => 'test@example.com', 'password' => 'password']);

        // login success
        $I->seeResponseCodeIs(200);

        // check if returned user data is contained expected email
        $I->seeResponseContainsJson(['email' => 'test@example.com']);
    }

    public function testLoginIsFailed(ApiTester $I): void
    {
        $I->wantToTest('Login is failed');

        // send invalid credential data
        $I->sendPOST('/api/login', ['email' => 'test@example.com', 'password' => '123456']);

        // check expected response code
        $I->seeResponseCodeIs(401);
    }

    public function authenticatedUserSuccessFetchProfile(ApiTester $I): void
    {
        $I->wantToTest('Authenticated user success fetch profile');

        // create user data
        $user = User::factory()->create([
            'email' => 'demo@gmail.com',
            'password' => bcrypt('qwerty123')
        ]);
        // create valid token
        $token = JWTAuth::fromUser($user);

        // set header token Authorization: Bearer {token}
        $I->amBearerAuthenticated($token);

        // send request
        $I->sendGET('/api/user');

        // check expected response code
        $I->seeResponseCodeIs(200);

        // check if response data is same with our init user data
        $I->seeResponseContainsJson(['email' => 'demo@gmail.com']);
    }
}
