<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\WorkingTime;
use App\Queue\BusyUsersQueueProvider;

class EspressoMachineSimulator
{
    /**
     * @var User[]
     */
    private $users;

    private $busyUsersQueueProvider;

    public function __construct(array $users)
    {
        $this->users = $users;
        $this->busyUsersQueueProvider = new BusyUsersQueueProvider($users);
    }

    public function serveUsers(): array
    {
        $usersServeOrderByHour = [];

        for ($hour = WorkingTime::START_HOUR; $hour < WorkingTime::END_HOUR; $hour++) {
            $usersServeOrderByHour [$hour] = $this->getUsersInOrder($hour);
        }

        return $usersServeOrderByHour;
    }

    private function getUsersInOrder(int $hour): array
    {
        $busyUsers = $this->busyUsersQueueProvider->getUsersQueue($hour);
        $nonBusyUsers = $this->getNonBusyUsers($busyUsers);

        return array_merge($busyUsers, $nonBusyUsers);
    }

    private function getNonBusyUsers(array $busyUsers): array
    {
        $nonBusyUsers = [];

        foreach ($this->users as $user) {
            if (!\in_array($user->getId(), $busyUsers, true)) {
                $nonBusyUsers [] = $user->getId();
            }
        }

        return $nonBusyUsers;
    }
}