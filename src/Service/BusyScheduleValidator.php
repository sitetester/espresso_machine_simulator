<?php

namespace App\Service;

use App\Entity\WorkingTime;

class BusyScheduleValidator
{
    public function validateInterval(array $scheduleInterval): void
    {
        if (!\is_numeric($scheduleInterval[0]) || !\is_numeric($scheduleInterval[1])) {
            throw new \InvalidArgumentException(
                sprintf(
                    'One of the interval values is not integer (%s-%s)',
                    $scheduleInterval[0],
                    $scheduleInterval[1]
                )
            );
        }

        $this->validateIntervalValueInRange($scheduleInterval[0]);
        $this->validateIntervalValueInRange($scheduleInterval[1]);

        if ($scheduleInterval[1] < $scheduleInterval[0]) {
            throw new \InvalidArgumentException(
                sprintf(
                    'End hour(%d) is less than start hour(%d).',
                    $scheduleInterval[1],
                    $scheduleInterval[0]
                )
            );
        }

    }

    private function validateIntervalValueInRange(int $intervalValue): void
    {
        if ($intervalValue > WorkingTime::END_HOUR || $intervalValue < WorkingTime::START_HOUR) {
            throw new \InvalidArgumentException(
                sprintf('Out of range (' . WorkingTime::START_HOUR . '-' . WorkingTime::END_HOUR . ') interval value: ' . $intervalValue)
            );
        }
    }
}