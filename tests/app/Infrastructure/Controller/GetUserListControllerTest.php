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
        $this->userDataSource
            ->expects('getUserList')
            ->once()
            ->andReturn(array(""));

        $response = $this->get('/api/users/list');

        $response->assertStatus(Response::HTTP_OK)->assertExactJson(['list' => array("")]);


    }

    /**
     * @test
     */
    public function returnsUserList()
    {
        $this->userDataSource
            ->expects('getUserList')
            ->once()
            ->andReturn(array("id: 1", "id: 3"));

        $response = $this->get('/api/users/list');

        $response->assertStatus(Response::HTTP_OK)->assertExactJson(['list' => array("id: 1", "id: 3")]);


    }

}
