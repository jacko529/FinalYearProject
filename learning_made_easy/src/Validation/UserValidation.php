<?php
namespace App\Validation;


use App\Repository\UserRepository;

class UserValidation
{

    protected $userRepo;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    public function validate($userRequestArray){
        // check properties
        if (!array_diff(['first_name', 'surname', 'email', 'password'], array_keys($userRequestArray))) {
            foreach($userRequestArray as $validate){
                if (empty($validate)){
                    return 'Missing property value';
                }
            }
        }
        // check email exists
        if(($this->userRepo->findUser($userRequestArray['email']))){
            return 'Email is already in use';
        }
        // check email has @
        if(!stripos($userRequestArray['email'],'@')){
            return 'Invalid email address';
        }


        return false;
    }



}