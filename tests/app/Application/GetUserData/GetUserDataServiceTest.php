<?php

namespace Tests\app\Application\GetUserData;

use App\Application\GetUserDataService\GetUserDataService;
use App\Domain\User;
use Exception;
use Mockery;
use App\Application\UserDataSource\UserDataSource;
use Tests\TestCase;

class GetUserDataServiceTest extends TestCase
{
    private UserDataSource $userDataSource;
    private GetUserDataService $getUserDataService;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->userDataSource = Mockery::mock(UserDataSource::class);
        $this->getUserDataService = new GetUserDataService($this->userDataSource);

        $this->app->bind(UserDataSource::class, fn () => $this->userDataSource);
    }

    /**
     * @test
     */
    public function userNotFound()
    {
        $expectedUser = new User(1, 'email@email.com');
        $id = 1;
        $this->userDataSource
            ->expects('findById')
            ->with('1')
            ->once()
            ->andThrow(new Exception('Usuario no encontrado'));

        $this->expectException(Exception::class);
        $this->getUserDataService->execute($id);
    }

    /**
     * @test
     */
    public function returnsUserData()
    {
        $expectedUser = new User(1, 'email@email.com');
        $id = 1;
        $this->userDataSource
            ->expects('findById')
            ->with('1')
            ->once()
            ->andReturn($expectedUser);

        $actualUser = $this->getUserDataService->execute($id);
        $this->assertEquals($expectedUser, $actualUser);
    }
}
