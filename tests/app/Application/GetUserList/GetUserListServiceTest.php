<?php

namespace Tests\app\Application\EarlyAdopter;

use App\Application\GetUserListService;
use App\Infrastructure\Providers\FakeUserDataSource;
use PHPUnit\Framework\TestCase;

class GetUserListServiceTest extends TestCase
{
    private GetUserListService $getUserListService;
    private FakeUserDataSource $fakeUserDataSource;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->fakeUserDataSource = new FakeUserDataSource();

        $this->getUserListService = new GetUserListService($this->fakeUserDataSource);
    }

    /**
     * @test
     */
    public function returnsEmptyWithNoUsers()
    {
        $expectedUsers = array("");
        $this->fakeUserDataSource->setUserList($expectedUsers);


        $response = $this->fakeUserDataSource->getUserList();

        $this->assertEquals($expectedUsers, $response);
    }

    /**
     * @test
     */
    public function returnsUserList()
    {
        $expectedUsers = array("id: 1", "id: 3", "id: 5");
        $this->fakeUserDataSource->setUserList($expectedUsers);
        $response = $this->fakeUserDataSource->getUserList();

        $this->assertEquals($expectedUsers, $response);

    }


}
