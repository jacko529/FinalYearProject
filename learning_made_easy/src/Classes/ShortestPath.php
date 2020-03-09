<?php

namespace App\Classes;

use App\Repository\LearningResourceRepository;

class ShortestPath
{

    protected $stage;
    protected $usersTime;
    protected $usersTopCategory;
    protected $usersEmails;
    protected $learningResourceRepository;
    protected $usersCourse;
    protected $lastConsumedItem;
    protected array $returnedArrays = [];
    protected array $journeyCosts;

    public function __construct(LearningResourceRepository $learningResourceRepository)
    {
        $this->learningResourceRepository = $learningResourceRepository;
    }

    public function setAll($stage, $usersTime, $usersTopCategory, $usersEmails, $usersCourse, $lastConsumedItem)
    {
        $this->stage = $stage;
        $this->usersTime = $usersTime;
        $this->usersTopCategory = $usersTopCategory;
        $this->usersEmails = $usersEmails;
        $this->usersCourse = $usersCourse;
        $this->lastConsumedItem = $lastConsumedItem;
    }

    public function findShortestPath()
    {
        // get the total cost of path
        // should always be the first item
        $shortestPath = $this->learningResourceRepository->KshortestPath(
            $this->lastConsumedItem,
            $this->stage,
//            array_key_first($absoluteArr)
            $this->usersTopCategory
        );
        foreach ($shortestPath->records() as $newItem) {
            $this->returnedArrays[] = $newItem->get('names');
            $learning[] = $newItem->get('learning');
            $this->journeyCosts[] = $newItem->get('costs');
            $totalCost[] = $newItem->get('totalCost');
        }


        $final = $this->findTimeAndStyle($this->usersTime, $totalCost, $this->usersTopCategory, $this->returnedArrays);

        $matchNextRecords = $this->learningResourceRepository->matchNext(
            $final,
            $this->usersEmails,
            $this->usersCourse
        );

        $finalValues = $this->filterNeo4jResponse($matchNextRecords, 'next');


        return $finalValues->values();
    }


    public function explainShortPath()
    {
        $firstJourney = $this->returnedArrays[0];
        $secondJourney = $this->returnedArrays[1];
        $thirdJourney = $this->returnedArrays[2];

        $firstCosts = $this->addMins($this->journeyCosts[0]);
        $secondCosts = $this->addMins($this->journeyCosts[1]);
        $thirdThird = $this->addMins($this->journeyCosts[2]);

        $a = $this->addDummyKey($firstCosts);
        $b = $this->addDummyKey($secondCosts);
        $c = $this->addDummyKey($thirdThird);

        $firstCombined = $this->combineNewArrays($a, $firstJourney);
        $secondCombined = $this->combineNewArrays($b, $secondJourney);
        $thirdCombined = $this->combineNewArrays($c, $thirdJourney);

        $test['first'] = $this->createFunction($firstCombined);
        $test['second'] = $this->createFunction($secondCombined);
        $test['third'] = $this->createFunction($thirdCombined);

        return $test;
    }

    /**
     *
     * allocate node link information for explainibility
     *
     * @param $array
     *
     * @return mixed
     */
    public function createFunction($array)
    {
        foreach ($array as $now => $content) {
            $testArray['nodes'][] = ['id' => $content, 'svg' => 'http://localhost:9000/networking/icon-memory-retention.png'];
            $testArray['links'][] = [
                'source' => $content,
                'target' => $this->has_next($array) ? next($array) : $content,
                'label' => $now
            ];
        }
        return $testArray;
    }


    public function addMins($array){
        foreach($array as $mins){
           $new[] =  str_replace($mins,$mins . ' minutes',$mins);
        }
        return $new;
    }

    private function combineNewArrays($arrayKeys, $arrayNeedingToBeCombined)
    {
        return array_combine(
            $arrayKeys,
            array_values($arrayNeedingToBeCombined)
        );
    }

    private function addDummyKey($arrayNeedingToBeAddedTo)
    {
        return array_merge(array('temp' => 'Current'), $arrayNeedingToBeAddedTo);
    }

    /**
     *
     * check if array has a next value (pointer)
     *
     * @param $array
     *
     * @return bool
     */
    private function has_next(array $array)
    {
        if (is_array($array)) {
            if (next($array) === false) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     *
     * ensure all global arrays are clear
     *
     */
    public function emptyReturn(): void
    {
        $this->returnedArrays = [];
        $this->journeyCosts = [];
    }

    public function findTimeAndStyle($userTime, $totalCostTimes, $topStyle, $options)
    {
        // most
        foreach ($options as $learn) {
            $words[] = substr_count(implode($learn), $topStyle);
        }

        $closestNumber = $this->getClosest($userTime, $totalCostTimes);

        // which index has the nearest time and most occoursances of learning resource
        $key = array_search($closestNumber, $totalCostTimes);

        $maxs = array_search(max($words), $words);

        if ($key === $maxs) {
            $finalOption = $options[$maxs][1];
        } else {
            $finalOption = $options[$key][1];
        }

        return $finalOption;
    }


    public function getClosest($search, $arr)
    {
        $closest = null;
        foreach ($arr as $item) {
            if ($closest === null || abs($search - $closest) > abs($item - $search)) {
                $closest = $item;
            }
        }
        return $closest;
    }

    /**
     * @param $records
     * @param $get
     *
     * @return array
     */
    public function filterNeo4jResponse($records, $get)
    {
        foreach ($records->records() as $newItem) {
            $returnedArray = $newItem->get($get);
        }
        return $returnedArray;
    }


}