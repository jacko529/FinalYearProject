<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
        protected $table = 'exam';
        public $timestamps = false;
        protected $fillable = [
            'name',
            'exam_date',
            'course_id',
        ];

        public function questions()
        {
            return $this->hasMany('App\Question');
        }

        public function setExamDateAttribute($examDate)
        {
            $this->attributes["exam_date"] =  strtotime(str_replace('/', '-', $examDate));
        }
}
