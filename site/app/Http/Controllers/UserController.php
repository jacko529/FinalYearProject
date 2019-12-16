<?php

namespace App\Http\Controllers;

use App\Classes\Responses\JsonResponses;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repository\Repository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected User $userNeo;

    /**
     * UserController constructor.
     * @param User $userNeo
     */
    public function __construct(User $userNeo){
        $this->userNeo = $userNeo;
    }

    public function create(UserRequest $request)
    {
        $user =  $this->userNeo->insert($request->input('first_name'),
                                $request->input('surname'),
                                $request->input('email'),
                                $request->input('password'),
                                $request->input('teacher')
                                );
        return JsonResponses::createOk([$user]);
    }

    public function login()
    {

    }


}
