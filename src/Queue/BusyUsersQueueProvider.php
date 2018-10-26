<?php

namespace App\Queue;

use App\Entity\User;

class BusyUsersQueueProvider
{
    /**
     * @var User[]
     */
    private $sortedBusyUsers;

    public function __construct(array $users)
    {
        $this->sortedBusyUsers = $this->filterBusyUsers(
            $this->sortUsersByStartHour($users)
        );
    }

    private function filterBusyUsers(array $users): array
    {
        /** @var User[] */
        $busyUsers = [];

        foreach ($users as $user) {
            if ($user->getBusyScheduleStartHour() !== null && $user->getBusyScheduleEndHour() !== null) {
                $busyUsers[] = $user;
            }
        }

        return $busyUsers;
    }

    private function sortUsersByStartHour(array $busyUsers): array
    {
        usort($busyUsers, function (User $first, User $second) {
            return $first->getBusyScheduleStartHour() > $second->getBusyScheduleStartHour();
        });

        return $busyUsers;
    }

    public function getUsersQueue(int $hour): array
    {
        $busyUsersByStartHour = $this->getBusyUsersByStartHour($hour);
        $busyUsersByEndHour = $this->getBusyUsersByEndHour($hour);

        return array_merge($busyUsersByStartHour, $busyUsersByEndHour);
    }

    private function getBusyUsersByStartHour(int $hour): array
    {
        $busyUsersByStartHour = [];

        foreach ($this->sortedBusyUsers as $user) {
            if ($user->getBusyScheduleStartHour() === $hour) {
                $busyUsersByStartHour[] = $user->getId();
            }
        }

        return $busyUsersByStartHour;
    }

    private function getBusyUsersByEndHour(int $hour): array
    {
        $busyUsersByEndHour = [];

        foreach ($this->sortedBusyUsers as $user) {
            if ($user->getBusyScheduleStartHour() < $hour && $user->getBusyScheduleEndHour() > $hour) {
                $busyUsersByEndHour[] = $user->getId();
            }
        }

        return $busyUsersByEndHour;
    }

}