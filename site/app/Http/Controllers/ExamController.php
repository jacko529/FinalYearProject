<?php

namespace App\Http\Controllers;

use App\Classes\Responses\JsonResponses;
use App\Course;
use App\Exam;
use App\Question;
use App\Repository\Repository;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    protected $model;
    protected $questionModel;

    public function __construct(Exam $exam, Question $question)
    {
        $this->model = new Repository($exam);
        $this->questionModel = new Repository($question);
    }

    public function index()
    {
        return ($this->model->all());
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
        return JsonResponses::createOk(['success']);
    }

}
