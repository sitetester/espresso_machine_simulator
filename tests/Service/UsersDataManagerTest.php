<?php

namespace App\Tests\Service;

use App\Service\UsersDataManager;
use PHPUnit\Framework\TestCase;

class UsersDataManagerTest extends TestCase
{
    public function testManageUsersData(): void
    {
        $userDataManager = new UsersDataManager();
        $users = $userDataManager->manageUsersData(
            $this->getUsersData()
        );

        // check if we have User entity mapped
        $this->assertInstanceOf('App\Entity\User', $users[0]);

        // check if all users are mapped
        $this->assertCount(8, $users);
    }

    private function getUsersData(): array
    {
        $users = [];
        $users[] = '1:11-12';
        $users[] = '2:10-11';
        $users[] = '3';
        $users[] = '4:15-17';
        $users[] = '5:9-10';
        $users[] = '6';
        $users[] = '7';
        $users[] = '8:9-12';

        return $users;

    }
}