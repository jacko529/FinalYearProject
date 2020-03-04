<?php

namespace App\Classes;

use App\Repository\LearningResourceRepository;
use GraphAware\Neo4j\Client\Client;
use GraphAware\Neo4j\Client\ClientInterface;

class ShortestPath
{

    protected $stage;
    protected $usersTime;
    protected $usersTopCategory;
    protected $usersEmails;
    protected $learningResourceRepository;
    protected $usersCourse;
    protected $lastConsumedItem;
    protected $client;
    protected $returnedArrays = [];


    public function __construct(LearningResourceRepository $learningResourceRepository )
    {
        $this->learningResourceRepository = $learningResourceRepository;

    }

    public function setAll($stage, $usersTime, $usersTopCategory, $usersEmails, $usersCourse, $lastConsumedItem){
        $this->stage = $stage;
        $this->usersTime = $usersTime;
        $this->usersTopCategory = $usersTopCategory;
        $this->usersEmails = $usersEmails;
        $this->usersCourse = $usersCourse;
        $this->lastConsumedItem = $lastConsumedItem;

    }

    public function findShortestPath(){

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
            $costs = $newItem->get('costs');
            $totalCost[] = $newItem->get('totalCost');
        }


        $final = $this->findTimeAndStyle($this->usersTime, $totalCost, $this->usersTopCategory, $this->returnedArrays);

        $matchNextRecords = $this->learningResourceRepository->matchNext($final, $this->usersEmails, $this->usersCourse);

        $finalValues = $this->filterNeo4jResponse($matchNextRecords, 'next');


        return $finalValues->values();
    }


    public function explainShortPath()
    {
        $first = $this->returnedArrays[0];
        $second = $this->returnedArrays[1];
        $third = $this->returnedArrays[2];
        $firstEndKey = array_key_last($first);
        $secondEndKey = array_key_last($second);
        $thirdEndKey = array_key_last($third);

        $test['first'] = $this->createFunction($first, $firstEndKey);
        $test['second'] = $this->createFunction($second, $secondEndKey);
        $test['third'] = $this->createFunction($third, $thirdEndKey);


        return $test;
    }


    public function createFunction($array, $finalKey){

        foreach($array as $now => $content){
            $testArray['nodes'][] = ['id'=> $content];
            $testArray['links'][] = ['source'=> $content,
                                    'target'=> $array[$now < 6 ? $now + 1 :  $finalKey],
                                    'label' => 'Weight'];
        }
        return $testArray;
    }

    public function emptyReturn(){
        $this->returnedArrays = [];
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