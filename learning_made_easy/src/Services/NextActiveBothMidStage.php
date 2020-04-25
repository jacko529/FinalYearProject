<?php

namespace App\Services;

use App\Classes\ShortestPath;
use NextActive;

class NextActiveBothMidStage implements NextActive
{

    private array $courseInformation;

    public function __construct(ShortestPath $shortestPath)
    {

    }

    public function getCourseInformation(): array
    {
        return $this->courseInformation;
    }

    public function findLatestCourseItem(array $courseInformation)
    {
        // TODO: Implement findLatestCourseItem() method.
    }
//

//

//
//    public function findLatestCourseItem(array $courseInformation)
//    {
//
//        foreach ($latestConsumedItem->records() as $itemsConsumed) {
//            $this->itemsC[] = ($itemsConsumed->get('name'));
//            $this->itemsC[] = ($itemsConsumed->get('max'));
//        }
//
//        $this->shortestPath->setAll(
//            $stage,
//            $user->getTime(),
//            $topCategory[0],
//            $usersEmail,
//            $courseName['name'],
//            $this->itemsC[0]
//        );
//        $this->jaccardIndex->setAll($usersEmail, $courseName['name'], $this->itemsC[0]);
//
//        if($courseName['image']){
//            $courseUrl = $this->s3->getS3($courseName['name'], $courseName['image']);
//        }
//
//        $firstCourse[] = [
//            'course' => $courseName['name'],
//            'course_image' => $courseUrl ?? null,
//            'shortest_path' => $this->shortestPath->findShortestPath(),
//            'explain_short_path' => $this->shortestPath->explainShortPath(),
//            'jarrard' => $this->jaccardIndex->findIndex()
//        ];
//        $this->jaccardIndex->clearAll();
//        $this->shortestPath->emptyReturn();
//
//        $firstCourse = $this->filterToAddS3Info->filter($index, $courseName['name'], $firstCourse);
//    }

    public function addUrl(array $courseInformation)
    {
        // TODO: Implement addUrl() method.
    }

    public function setRequiredCourseDetails(array $requiredCourseDetails)
    {
        // TODO: Implement setRequiredCourseDetails() method.
    }
}