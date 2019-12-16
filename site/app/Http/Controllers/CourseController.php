<?php

namespace App\Http\Controllers;

use App\Classes\Responses\JsonResponses;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    protected Course $courseNeo;

    public function __construct(Course $course)
    {
        $this->courseNeo = $course;
    }

    /**
     * @param Request $request
     * // @todo change to fillable actions only
     * @return mixed
     */
    public function create(Request $request){
        $this->courseNeo->insert($request->input('course'),
                                 $request->input('user'));

        return JsonResponses::createOk(['success']);
    }

    public function delete(Request $request){
        $this->courseNeo->delete($request->input('name'));
        return JsonResponses::createOk(['success']);

    }

}
