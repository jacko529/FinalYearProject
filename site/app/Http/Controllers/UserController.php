<?php

namespace App\Http\Controllers;

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
    public function create(Request $request){
        $this->model->create($request->json()->all());
//      $this->model->create($request->only($this->model->getModel()->fillable));
        return response()->json($this->user);
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
