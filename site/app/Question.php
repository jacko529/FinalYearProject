<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'date_taken',
        'marks',
        'exam_id',
    ];

    public function exam(){
        return $this->belongsTo(Exam::class);
    }

    public function setDateTakenAttribute($examDate)
    {
        $this->attributes["date_taken"] =  strtotime(str_replace('/', '-', $examDate));
    }
}
