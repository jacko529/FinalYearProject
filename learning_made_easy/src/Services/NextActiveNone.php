<?php

namespace App\Services;

use App\Classes\ShortestPath;
use NextActive;

class NextActiveNone implements NextActive
{

    private array $courseInformation;

    public function getCourseInformation(): array
    {

    }

    public function findLatestCourseItem(array $courseInformation)
    {
        // TODO: Implement findLatestCourseItem() method.
    }


    public function addUrl(array $courseInformation)
    {
        // TODO: Implement addUrl() method.
    }

    public function setRequiredCourseDetails(array $requiredCourseDetails)
    {
        // TODO: Implement setRequiredCourseDetails() method.
    }
}