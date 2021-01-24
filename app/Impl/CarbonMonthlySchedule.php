<?php

namespace App\Impl;

use Carbon\CarbonImmutable;

class CarbonMonthlySchedule implements MonthlySchedule
{
    /**
     * @param \DateTimeInterface $scheduleStartDate
     * @param int $scheduleInMonths
     * @return array<String>
     */
    public function calculate(\DateTimeInterface $scheduleStartDate, int $scheduleInMonths): array
    {
        $startDate = CarbonImmutable::instance($scheduleStartDate);
        $startDate->settings(['monthOverflow' => false]);

        $schedules = [];

        for ($i = 1; $i <= $scheduleInMonths; $i++) {
            $schedules[] = $startDate->addMonths($i)->format('Y-m-d');
        }

        return $schedules;
    }
}
