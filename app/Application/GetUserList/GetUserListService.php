<?php

namespace App\Application\GetUserList;

use App\Application\UserDataSource\UserDataSource;
use Exception;

class GetUserListService
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
     * @throws Exception
     */
    public function execute():array
    {

        $userList = $this->userDataSource->getUserList();
        return $userList;
    }

}
