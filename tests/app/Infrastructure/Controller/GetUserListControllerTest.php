<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use Illuminate\Http\Response;
use Tests\TestCase;
use Mockery;
use Exception;


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

        $response = $this->get('/api/users/list/');

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR)->assertExactJson(['error' => 'Hubo un error al realizar la peticion']);
    }

}
