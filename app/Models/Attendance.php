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

    public function saveAttendance($input)
    {
        $this->updateOrCreate(
            [
                'user_id' => Auth::id(),
                'date' => $input['date']
            ],
            $input
        );
    }

    public function addColumn($request)
    {
        $add = [
            'user_id' => Auth::id(),
            'date' => today()
        ];
        $input = $request->merge($add)->all();
        return $input;
    }

    public function getStatus($existJudgement)
    {
        $status = '出社時間登録';
        if ($existJudgement) {
            $attendance = $this->where('user_id', Auth::id())
                               ->where('date', today())->first();
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
}
