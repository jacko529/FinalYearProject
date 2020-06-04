<?php


namespace App\Classes;


use Aws\S3\S3Client;

class FilterToAddS3Information
{



    protected $s3;
    public function __construct()
    {
        $this->s3 = new S3Helper();
    }

    public function filter($index, $course, $firstCourse)
    {
        //todo test if there is a mix of files and urls
        // when they have started there course but dont have similar users yet


        if (!array_key_exists('jarrard', $firstCourse[$index]) && array_key_exists('shortest_path', $firstCourse[$index])) {
            $firstCourse[$index]['shortest_path']['resource']['url'] = $this->s3->getS3(strtolower($course), $firstCourse[$index]['shortest_path']['resource']['name_of_file']);
            // when they are in the middle of there course
        } elseif (array_key_exists('jarrard', $firstCourse[$index]) && array_key_exists('shortest_path', $firstCourse[$index])) {
            $firstCourse[$index]['shortest_path']['resource']['url'] = $this->s3->getS3(strtolower($course), $firstCourse[$index]['shortest_path']['resource']['name_of_file']);
            if(!$firstCourse[$index]){
                $firstCourse[$index]['jarrard']['resource']['url'] =$this->s3->getS3(strtolower($course), $firstCourse[$index]['jarrard']['resource']['name_of_file']);
            }
            // when it is a first course item in the journey
        } elseif (!array_key_exists('shortest_path', $firstCourse[$index]) && array_key_exists('jarrard', $firstCourse[$index])) {
            $firstCourse[$index]['jarrard']['resource']['url'] = $this->s3->getS3(strtolower($course), $firstCourse['jarrard']['resource']['name_of_file']);
            // when it is a first course item in the journey
        } elseif (!array_key_exists('jarrard', $firstCourse[$index]) && !array_key_exists('shortest_path', $firstCourse)){
            $url = $this->s3->getS3(strtolower($course), $firstCourse[$index]['resource']['name_of_file']);
            ($url !== null) ? $firstCourse[$index]['resource']['url'] = $url : null;
        }



        return  $firstCourse;

    }





}