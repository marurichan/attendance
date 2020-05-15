<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Attendance extends Model
{
    protected $table = 'attendance';

    protected $fillable = [
        'user_id',
        'date',
        'start_time',
        'end_time',
        'absent_content',
        'modify_content',
        'updated_at',
        'created_at'
    ];

    protected $date = [
        'date',
        'start_time',
        'end_time'
    ];

    public static function existJudgement($attendance, $date)
    {
        return $attendance->where('user_id', Auth::id())
                          ->where('date', $date)
                          ->exists();
    }
}
