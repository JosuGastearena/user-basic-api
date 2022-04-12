<?php

namespace Tests\app\Application\EarlyAdopter;

use Mockery;
use App\Application\UserDataSource\UserDataSource;
use Tests\TestCase;

class GetUserListServiceTest extends TestCase
{
    private UserDataSource $userDataSource;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->userDataSource = Mockery::mock(UserDataSource::class);
        $this->app->bind(UserDataSource::class, fn () => $this->userDataSource);
    }

    /**
     * @test
     */
    public function returnsEmptyWithNoUsers()
    {
        $expectedUsers = array("");
        $this->userDataSource
            ->expects('getUserList')
            ->once()
            ->andReturn(array(""));


        $response = $this->userDataSource->getUserList();

        $this->assertEquals($expectedUsers, $response);
    }

    /**
     * @test
     */
    public function returnsUserList()
    {
        $expectedUsers = array("id: 1", "id: 3", "id: 5");
        $this->userDataSource
            ->expects('getUserList')
            ->once()
            ->andReturn(array("id: 1", "id: 3", "id: 5"));


        $response = $this->userDataSource->getUserList();

        $this->assertEquals($expectedUsers, $response);
    }
}
