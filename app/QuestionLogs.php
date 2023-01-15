<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionLogs extends Model
{
    use SoftDeletes;

    protected $fillable = ['question_id', 'action'];

    protected $table = 'question_logs';
}
