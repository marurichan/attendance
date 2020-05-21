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

    protected $dates = [
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

    public static function attendanceSave($input, $existJudgement, $attendance)
    {
        if ($existJudgement) {
            $attendance->where('user_id', $input['user_id'])
                        ->where('date', $input['date'])
                        ->first()->fill($input)->save(); 
        } else {
            $attendance->fill($input)->save();
        }
    }

    public static function inputUpdate($request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $input['date'] = date('Y-m-d');
        return $input;
    }
}
