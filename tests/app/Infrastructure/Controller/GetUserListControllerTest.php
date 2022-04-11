<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Infrastructure\Providers\FakeUserDataSource;
use Exception;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;


class GetUserListControllerTest extends TestCase
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
    public function genericErrorGivenFetchingUser()
    {

        $this->userDataSource
            ->expects('getUserList')
            ->once()
            ->andThrow(new Exception('Hubo un error al realizar la peticion'));

        $response = $this->get('/api/users/list');

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR)->assertExactJson(['error' => 'Hubo un error al realizar la peticion']);
    }

    /**
     * @test
     */
    public function returnsEmptyWithNoUsers()
    {
        $fakeDataSource = new FakeUserDataSource();
        $expectedUsers = [""];
        $fakeDataSource->setUserList($expectedUsers);
        $response = $fakeDataSource->getUserList();

        $this->assertEquals($expectedUsers, $response);

    }

    /**
     * @test
     */
    public function returnsUserList()
    {
        $fakeDataSource = new FakeUserDataSource();

        $expectedUsers = array("id: 1", "id: 3", "id: 5");
        $fakeDataSource->setUserList($expectedUsers);
        $response = $fakeDataSource->getUserList();

        $this->assertEquals($expectedUsers, $response);

    }



}
