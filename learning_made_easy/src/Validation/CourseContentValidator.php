<?php


namespace App\Validation;


use App\Repository\CourseRepository;
use App\Repository\LearningResourceRepository;

class CourseContentValidator
{

    protected $learningResourceRepo;
    public function __construct(LearningResourceRepository $learningResourceRepo)
    {
        $this->learningResourceRepo = $learningResourceRepo;
    }
    public function validate($userRequestArray, $email, $file){
        // check properties
        $missing = ['selectedCourse', 'resourceName', 'stage', 'time', 'learning_style'];
        if (!array_diff($missing, array_keys($userRequestArray))) {
            foreach($userRequestArray as $index =>$validate){
                if(in_array($index , $missing)){
                    if (empty($validate)){
                            return 'Missing property value';
                    }
                }
            }
        }
        // check email exists
        if(($this->learningResourceRepo->findResource($email))){
            return 'Learning resource with this name is already in use';
        }

        if ($file === null && empty($userRequestArray['link'])){
            return 'No associated learning resources';
        }

        return false;
    }
}