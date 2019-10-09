<?php

namespace App\Http\Controllers;

use App\Question;
use App\Exam;
use App\Repository\Repository;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    protected $questionModel;
    protected $examModel;

    public function __construct(Question $question, Exam $exam)
    {
        $this->questionModel = new Repository($question);
        $this->examModel = new Repository($exam);
    }

    /**
     * all questions by exam id
     *
     * @param $id
     * @return mixed
     */
    public function index()
    {
        dd($this->questionModel->with('exam'));
//        return

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
