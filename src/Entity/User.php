<?php

namespace App\Entity;

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int|null
     */
    private $busyScheduleStartHour = null;

    /**
     * @var int|null
     */
    private $busyScheduleEndHour = null;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getBusyScheduleStartHour(): ?int
    {
        return $this->busyScheduleStartHour;
    }

    /**
     * @param int $busyScheduleStartHour
     * @return User
     */
    public function setBusyScheduleStartHour(int $busyScheduleStartHour): User
    {
        $this->busyScheduleStartHour = $busyScheduleStartHour;

        return $this;
    }

    /**
     * @return int
     */
    public function getBusyScheduleEndHour(): ?int
    {
        return $this->busyScheduleEndHour;
    }

    /**
     * @param int $busyScheduleEndHour
     * @return User
     */
    public function setBusyScheduleEndHour(int $busyScheduleEndHour): User
    {
        $this->busyScheduleEndHour = $busyScheduleEndHour;

        return $this;
    }


}