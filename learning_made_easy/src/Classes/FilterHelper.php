<?php


namespace App\Classes;


class FilterHelper
{

    public function repositionedArray($firstCourse){

        foreach($firstCourse as $more => $key){
            $now = $key['time'];
            $firstCourse[$more]['resource']['time'] = $now;
            unset($firstCourse[$more]['time']);
        }

        return $firstCourse;
    }

    public function repositionedSecondaryArray($firstCourse){
        foreach($firstCourse as $more => $key){
                $time  = end($firstCourse);
                $firstCourse[$more]['time'] = $time;
            unset($firstCourse['time']);
        }

        return $firstCourse;
    }

}