<?php

namespace App\Tests\Service;

use App\Service\EspressoMachineSimulator;
use App\Service\UsersDataManager;
use PHPUnit\Framework\TestCase;

class EspressoMachineSimulatorTest extends TestCase
{
    protected $usersServeOrderByHour;

    protected function setUp(): void
    {
        $users = (new UsersDataManager())->manageUsersData(
            $this->getUsersData()
        );

        $this->usersServeOrderByHour = (new EspressoMachineSimulator($users))->serveUsers();
    }

    public function testUsersServeOrderAt9Am(): void
    {
        // busy users
        $this->assertEquals(5, $this->usersServeOrderByHour[9][0]);
        $this->assertEquals(8, $this->usersServeOrderByHour[9][1]);

        // other users order (first come first server principle)
        $this->assertEquals(1, $this->usersServeOrderByHour[9][2]);
        $this->assertEquals(2, $this->usersServeOrderByHour[9][3]);
        $this->assertEquals(3, $this->usersServeOrderByHour[9][4]);
        $this->assertEquals(4, $this->usersServeOrderByHour[9][5]);
        $this->assertEquals(6, $this->usersServeOrderByHour[9][6]);
        $this->assertEquals(7, $this->usersServeOrderByHour[9][7]);
    }

    public function testUsersServeOrderAt10Am(): void
    {
        // busy users are served first
        $this->assertEquals(2, $this->usersServeOrderByHour[10][0]);
        $this->assertEquals(8, $this->usersServeOrderByHour[10][1]);

        // other users order (first come first server principle)
        $this->assertEquals(1, $this->usersServeOrderByHour[10][2]);
        $this->assertEquals(3, $this->usersServeOrderByHour[10][3]);
        $this->assertEquals(4, $this->usersServeOrderByHour[10][4]);
        $this->assertEquals(5, $this->usersServeOrderByHour[10][5]);
        $this->assertEquals(6, $this->usersServeOrderByHour[10][6]);
        $this->assertEquals(7, $this->usersServeOrderByHour[10][7]);
    }

    public function testUsersServeOrderAt13Pm(): void
    {
        // no one is busy, all will be served in first come, first serve way
        $this->assertEquals(1, $this->usersServeOrderByHour[13][0]);
        $this->assertEquals(2, $this->usersServeOrderByHour[13][1]);
        $this->assertEquals(3, $this->usersServeOrderByHour[13][2]);
        $this->assertEquals(4, $this->usersServeOrderByHour[13][3]);
        $this->assertEquals(5, $this->usersServeOrderByHour[13][4]);
        $this->assertEquals(6, $this->usersServeOrderByHour[13][5]);
        $this->assertEquals(7, $this->usersServeOrderByHour[13][6]);
        $this->assertEquals(8, $this->usersServeOrderByHour[13][7]);
    }

    public function testUsersServeOrderAt16Pm(): void
    {
        // busy users are served first
        $this->assertEquals(4, $this->usersServeOrderByHour[16][0]);
        $this->assertEquals(1, $this->usersServeOrderByHour[16][1]);
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