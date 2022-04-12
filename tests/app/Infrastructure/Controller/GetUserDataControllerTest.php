<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use Exception;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class GetUserDataControllerTest extends TestCase
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
            ->expects('findById')
            ->with('1')
            ->once()
            ->andThrow(new Exception('Hubo un error al realizar la peticion'));

        $response = $this->get('/api/users/1');

        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Hubo un error al realizar la peticion']);
    }

    /**
     * @test
     */
    public function userNotFoundById()
    {
        $this->userDataSource
            ->expects('findById')
            ->with('999')
            ->once()
            ->andThrow(new Exception('Usuario no encontrado'));

        $response = $this->get('/api/users/999');

        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Usuario no encontrado']);
    }
    /**
     * @test
     */
    public function returnsUserData()
    {
        $user = new User(1, 'email@email.com');
        $this->userDataSource
            ->expects('findById')
            ->with('1')
            ->once()
            ->andReturns($user);

        $response = $this->get('/api/users/1');

        $response->assertStatus(Response::HTTP_OK)->assertExactJson(['id' => $user->getId(), 'email'=> $user->getEmail()]);
    }
}
