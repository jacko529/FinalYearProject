<?php

namespace App\Classes;

use App\Repository\LearningResourceRepository;

class JaccardIndex
{

    protected LearningResourceRepository $learningResourceRepository;
    protected $usersEmail;
    protected $usersCourse;

    public function __construct(LearningResourceRepository $learningResourceRepository)
    {
        $this->learningResourceRepository = $learningResourceRepository;
    }

    public function setAll($usersEmail, $course){
        $this->usersEmail = $usersEmail;
        $this->usersCourse = $course;
    }

    public function findIndex(){

        $JaccardIndexArray = $this->getJarrardIndex($this->usersEmail);
        $jaccardNext = $this->learningResourceRepository->matchNext($JaccardIndexArray[0], $this->usersEmail, $this->usersCourse);
        $next = $this->filterNeo4jResponse($jaccardNext, 'next');
//        $firstCourse['jarrard'][] = ;

        return $next->values();
    }



    public function getJarrardIndex($email)
    {
        $this->learningResourceRepository->deleteSimlarReltionships();
        $this->learningResourceRepository->reRunMatchingProcess();
        $topIndex = $this->learningResourceRepository->jaradCollabortiveFiltering($email);
        foreach ($topIndex->records() as $newItem) {
            $returnedArrays[] = $newItem->get('name');
            $returnedArrays[] = $newItem->get('index');
        }

        return $returnedArrays;
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