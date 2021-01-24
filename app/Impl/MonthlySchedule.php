<?php

namespace App\Impl;


interface MonthlySchedule
{
    /**
     * @param \DateTimeInterface $scheduleStartDate
     * @param int $scheduleInMonths
      * @return array<String>
     */
    public function calculate(\DateTimeInterface $scheduleStartDate, int $scheduleInMonths): array;
}
