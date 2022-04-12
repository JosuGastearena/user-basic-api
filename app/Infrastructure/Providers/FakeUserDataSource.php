<?php

namespace App\Infrastructure\Providers;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;

class FakeUserDataSource implements UserDataSource
{

    private $userList = array("id: 1", "id: 3", "id: 5");


    public function findByEmail(string $email): User
    {
        // TODO: Implement findByEmail() method.
    }

    public function setUserList($userList): void
    {
        $this->userList = $userList;
    }

    public function getUserList():array
    {
        return $this->userList;
    }

    public function getUser():User
    {
        return new User(1, 'email@email.com');

    }

    public function findById(string $id): User
    {
        return $this->getUser();
    }
}
