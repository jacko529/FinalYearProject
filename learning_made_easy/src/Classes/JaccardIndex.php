<?php

namespace App\Classes;

use App\Repository\LearningResourceRepository;
use App\Classes\FilterHelper;

class JaccardIndex
{

    protected LearningResourceRepository $learningResourceRepository;
    protected $usersEmail;
    protected $usersCourse;
    protected $lastConsumedItem;
    protected FilterHelper $filterHelper;

    public function __construct(LearningResourceRepository $learningResourceRepository, FilterHelper $filterHelper)
    {
        $this->filterHelper = $filterHelper;
        $this->learningResourceRepository = $learningResourceRepository;
    }

    public function setAll($usersEmail, $course, $lastConsumedItem)
    {
        $this->usersEmail = $usersEmail;
        $this->usersCourse = $course;
        $this->lastConsumedItem = $lastConsumedItem;
    }
    public function clearAll()
    {
        $this->usersEmail = null;
        $this->usersCourse = null;
        $this->lastConsumedItem = null;
    }

    public function findIndex()
    {
        $JaccardIndexArray = $this->getJarrardIndex($this->usersEmail);
        if ($JaccardIndexArray) {
            $jaccardNext = $this->learningResourceRepository->matchNext(
                $JaccardIndexArray[0],
                $this->usersEmail,
                $this->usersCourse,
                $this->lastConsumedItem
            );

            return $this->filterHelper->repositionedSecondaryArray($jaccardNext);
        }

        return null;
    }


    public function getJarrardIndex($email)
    {
        $returnedArrays = [];
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
    public function filterNeo4jResponse($records, $get): array
    {
        $returnedArray = [];

        foreach ($records->records() as $newItem) {
            $returnedArray = $newItem->get($get);
        }

        return $returnedArray;
    }
}