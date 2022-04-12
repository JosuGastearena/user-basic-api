<?php

namespace App\Application\GetUserDataService;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;

class GetUserDataService
{
    /**
     * @var UserDataSource
     */
    private $userDataSource;

    /**
     * IsEarlyAdopterService constructor.
     * @param UserDataSource $userDataSource
     */
    public function __construct(UserDataSource $userDataSource)
    {
        $this->userDataSource = $userDataSource;
    }

    /**
     * @param string $id
     * @return User
     */
    public function execute(string $id): User
    {
        $user = $this->userDataSource->findById($id);

        return $user;
    }
}
