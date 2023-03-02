<?php


namespace Tests\Api;

use Tests\Support\ApiTester;

class JsonDataCest
{
    private $token;

    //change it to your actual data once you fill a DB
    //I have this IDs only because my DB is exists and not empty,
    //Tests will fail otherwise
    const ENTRY_TO_DELETE_ID = 4;
    const ENTRY_TO_UPDATE_ID = 2;

    public function _before(ApiTester $I)
    {
        // авторизация и получение токена
        $I->sendPOST('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);
        $response = json_decode($I->grabResponse());
        $this->token = $response->authorisation->token;

        $I->haveHttpHeader('Host', '127.0.0.1:8000');
        $I->haveHttpHeader('Port', '8000');
    }

    public function indexTest(ApiTester $I)
    {
        $token = $this->token;
        $I->amBearerAuthenticated($token);
        $uri = '/api/data/index/';
        $I->sendGET($uri);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContains('(User ID)');
    }

    public function createTest(ApiTester $I)
    {
        $I->wantTo('create a new data list');
        $I->amBearerAuthenticated($this->token);

        $data = ['data' => '{"name": "John"}', 'token' => $this->token];
        $I->sendPOST('/api/data/store/', $data);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['status' => 'success']);
    }

    public function updateTest(ApiTester $I)
    {
        $I->wantTo('update an existing data list');
        $I->amBearerAuthenticated($this->token);

        /* Must be an entry that have the following structure or this test could not be passed
         * {
                "employees":[
                    {"firstName":"John", "lastName":"Doe"},
                    {"firstName":"Anna", "lastName":"Smith"},
                    {"firstName":"Peter", "lastName":"Jones"}
                ]
            }
         */
        $data = ['id' => self::ENTRY_TO_UPDATE_ID, 'code' => '$data->employees[0]->firstName = "Mark";',
            'token' => $this->token];
        $url = '/api/data/update/' . self::ENTRY_TO_UPDATE_ID;
        $I->sendPOST($url, $data);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['status' => 'success']);
    }


    public function showTest(ApiTester $I)
    {
        $I->wantTo('get a single data list');
        $I->amBearerAuthenticated($this->token);

        //DB should not be empty
        $url = '/api/data/' . self::ENTRY_TO_UPDATE_ID;
        $I->sendGET($url);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['status' => 'success']);
    }

    public function destroyTest(ApiTester $I)
    {
        $I->wantTo('delete an existing data list');
        $I->amBearerAuthenticated($this->token);

        $url = '/api/data/delete/' . self::ENTRY_TO_DELETE_ID;
        $I->sendDELETE($url);
        $I->seeResponseCodeIs(200);
        $I->dontSeeResponseContains('<p>' . self::ENTRY_TO_DELETE_ID . '</p>');
    }
}
