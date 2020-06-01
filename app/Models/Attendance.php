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
    ];

    protected $dates = [
        'date',
        'start_time',
        'end_time'
    ];

    public function saveAttendance($inputs, $userId, $date)
    {
        $this->updateOrCreate(
            [
                'user_id' => $userId,
                'date' => $date
            ],
            $inputs
        );
    }

    public function startSaveAttendance($inputs, $userId)
    {
        $attendance = $this->where('user_id', $userId)
                           ->where('date', $inputs['date']);
        if ($attendance->start_time === null) {
            $this->saveAttendance($inputs, $userId, $inputs['date']);
        }
    }

    public function endSaveAttendance($inputs, $userId)
    {
        $attendance = $this->where('user_id', $userId)
                           ->where('date', $inputs['date']);
        if ($attendance->start_time !== null && $attendance->end_time === null) {
            $this->saveAttendance($inputs, $userId, $inputs['date']);
        }
    }

    public function addColumn($request, $userId)
    {
        $add = [
            'user_id' => $userId,
            'date' => today()
        ];
        $inputs = $request->merge($add)->all();
        return $inputs;
    }

    public function getStatus()
    {
        $status = '出社時間登録';
        $attendance = $this->where('user_id', Auth::id())
                           ->where('date', today())->first();
        if ($attendance !== null) {
            if ($attendance->start_time !== null) {
                $status = '退社時間登録';
            }
            if ($attendance->end_time !== null) {
                $status = '退社済み';
            }
            if ($attendance->absent_content !== null) {
                $status = '欠席';
            }
        }
        return $status;
    }

    public function getUserAttendances($userId)
    {
        return $attendances = $this->where('user_id', $userId)
                                   ->orderBy('date', 'desc')->get();
    }

    public function calcStudyTime()
    {
        return $this->end_time->diffInHours($this->start_time);
    }
}
