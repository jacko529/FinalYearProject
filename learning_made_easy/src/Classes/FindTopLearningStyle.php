<?php


namespace App\Classes;


class FindTopLearningStyle
{

    public function findTop($arrayOfLearningStyles)
    {
        $sortedArray = arsort($arrayOfLearningStyles, SORT_REGULAR);

        return $sortedArray[0];
    }

    public function arrayInOrder($arrayOfLearningStyles){

        return  arsort($arrayOfLearningStyles, SORT_REGULAR);

    }



    public function setAll($arrayOfAllOnCourse){
        $sortedArrayTop = [];
        foreach($arrayOfAllOnCourse as $item){
            arsort($item, SORT_REGULAR);
            $sortedArrayTop[key($item)] = reset($item);
        }
        $countedAmounts = array_count_values(array_keys($sortedArrayTop));
        arsort($countedAmounts);

        return key($countedAmounts);
    }


}