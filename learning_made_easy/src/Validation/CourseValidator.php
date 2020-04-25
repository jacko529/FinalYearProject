<?php


namespace App\Validation;


use App\Repository\CourseRepository;

class CourseValidator
{
    protected $courseRepo;
    public function __construct(CourseRepository $couresRepository)
    {
        $this->courseRepo = $couresRepository;
    }
    public function validate($userRequestArray, $file, $email){
        // check properties
        if (!array_diff(['name'], array_keys($userRequestArray))) {
            foreach($userRequestArray as $validate){
                if (empty($validate)){
                    return 'Missing property value';
                }
            }
        }

        // check email exists
        if(($this->courseRepo->findCourse($email))){
            return 'There is already a course named this';
        }
        // check email has @
        if(!$file){
            return 'No file included';
        }

        $mime = mime_content_type('/tmp/swoole.upfile.' . pathinfo($file, PATHINFO_EXTENSION));

        if ( !in_array( $mime,  ['image/png', 'image/jpeg'])){
            return 'Unsupported file type';
        }
        return false;
    }}