<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
        protected $fillable = [
            'name',
            'exam_date',
            'topic_id',
            'teacher_id',
            'student_id',
        ];

        public function questions()
        {
            return $this->hasMany('App\Question');
        }
}
