<?php

namespace App\Http\Controllers;

use App\Course;
use App\Repository\Repository;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    protected $model;

    public function __construct(Course $course)
    {
        $this->model = new Repository($course);
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


    /**
     * @param Request $request
     * // @todo change to fillable actions only
     * @return mixed
     */
    public function create(Request $request){
        $this->model->create($request->json()->all());
        return response()->json($this->user);
    }


}
