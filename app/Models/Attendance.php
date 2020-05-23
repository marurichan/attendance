<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    public function existJudgement($date)
    {
        return $this->where('user_id', Auth::id())
                    ->where('date', $date)
                    ->exists();
    }

    public function attendanceSave($input, $existJudgement)
    {
        if ($existJudgement) {
            $this->where('user_id', $input['user_id'])
                        ->where('date', $input['date'])
                        ->first()->fill($input)->save(); 
        } else {
            $this->fill($input)->save();
        }
    }

    public function inputUpdate($request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $input['date'] = today();
        return $input;
    }

    public function getStatus($existJudgement)
    {
        $status = '出社時間登録';
        $attendance = $this->where('user_id', Auth::id())
                           ->where('date', today())->first();
        if ($existJudgement) {
            if ($attendance->start_time) {
                $status = '退社時間登録';
            }
            if ($attendance->end_time) {
                $status = '退社済み';
            }
            if ($attendance->absent_content) {
                $status = '欠席';
            }
        }
        return $status;
    }
}
