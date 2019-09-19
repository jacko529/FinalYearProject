<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    protected $user;

    /**
     * Undocumented function
     *
     * @param User $user
     */
    public function __construct(User $user){
        $this->user = $user;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request){
        $this->user->fill($request->json()->all());
        $this->user->save();
        return response()->json($this->user);
    }


}
