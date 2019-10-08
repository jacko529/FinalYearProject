<?php

namespace App\Http\Controllers;

use App\Classes\Responses\JsonResponses;
use App\Http\Requests\UserRequest;
use App\Repository\Repository;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    protected $model;

    /**
     * UserController constructor.
     * @param User $user
     */
    public function __construct(User $user){
        $this->model = new Repository($user);
    }

    /**
     * @param Request $request
     * // @todo change to fillable actions only
     * @return mixed
     */
    public function create(UserRequest $request){
        $this->model->create($request->only($this->model->getModel()->fillable));
        return JsonResponses::createOk(['success']);
    }

    public function index()
    {
        return $this->model->all();
    }

    public function show($id)
    {
        return $this->model->show($id);
    }

    /**
     * @todo add only fillable update items
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $this->model->update($request->json()->all(), $id);
    }

    public function destroy($id)
    {
        return $this->model->delete($id);
    }


}
