<?php

namespace App\Service;

use App\Entity\User;

class UsersDataManager
{
    private $busyScheduleValidator;

    public function __construct()
    {
        $this->busyScheduleValidator = new BusyScheduleValidator();
    }

    public function manageUsersData(array $usersData): array
    {
        /** @var User[] */
        $users = [];
        foreach ($usersData as $userData) {
            $users[] = $this->mapToUserEntity($userData);
        }

        return $users;
    }

    private function mapToUserEntity(string $userData): User
    {
        $busySchedule = null;

        if (strpos($userData, ':') !== false) {
            [$id, $busySchedule] = explode(':', $userData);
        } else {
            $id = $userData;
        }

        $user = new User();
        $user->setId($id);

        if ($busySchedule !== null) {
            $busyScheduleInterval = explode('-', $busySchedule);
            $this->busyScheduleValidator->validateInterval($busyScheduleInterval);
            $user
                ->setBusyScheduleStartHour($busyScheduleInterval[0])
                ->setBusyScheduleEndHour($busyScheduleInterval[1])
            ;
        }

        return $user;
    }
}