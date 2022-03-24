<?php
declare(strict_types=1);

namespace App\Services;


class RedmineTimeEntriesService implements TimeEntriesServiceInterface
{
    private $timeEntries;

    public function __construct(array $timeEntries)
    {
        $this->timeEntries = $timeEntries;
    }

    public function getGroupedByUser() : array
    {
        $return = [];
        foreach ($this->timeEntries as $timeEntry) {
            $return[$timeEntry['user']['id']][] = $timeEntry;
        }

        return $return;
    }
}
