<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionOptions extends Model
{
    use SoftDeletes;

    protected $fillable = ['question_id', 'option', 'correct'];

    protected $table = 'question_options';
}
