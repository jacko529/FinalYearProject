<?php


interface NextActive
{

    public function getCourseInformation() : array;

    public function findLatestCourseItem(array $courseInformation);

    public function addUrl(array $courseInformation);

    public function setRequiredCourseDetails(array $requiredCourseDetails);
}