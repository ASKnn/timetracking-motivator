<?php


namespace App\Services;


interface TimeEntriesServiceInterface
{
    public function __construct(array $timeEntries);

    public function getGroupedByUser() : array;
}
