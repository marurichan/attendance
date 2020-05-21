<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AttendanceRequest;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    private $attendance;

    public function __construct(Attendance $attendance)
    {
        $this->middleware('auth');
        $this->attendance = $attendance;
    }

    /**
     * 勤怠登録画面表示
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $status = '出社時間登録';
        $existJudgement = Attendance::existJudgement($this->attendance, date('Y/m/d'));
        if ($existJudgement) {
            $attendance = $this->attendance->where('user_id', Auth::id())
                                           ->where('date', date('Y/m/d'))->first();
            if ($attendance->absent_content) {
                $status = '欠席';
            } else {
                if ($attendance->end_time) {
                    $status = '退社済み';
                } else {
                    if ($attendance->start_time) {
                        $status = '退社時間登録';
                    }
                }
            }
        }
        return view('user.attendance.index', compact('status'));
    }

    /**
     * 勤怠登録
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function timeStore(Request $request)
    {
        $input = Attendance::inputUpdate($request);
        $existJudgement = Attendance::existJudgement($this->attendance, $input['date']);
        Attendance::attendanceSave($input, $existJudgement, $this->attendance);
        return redirect()->route('attendance.index');
    }

    /**
     * 欠席登録画面表示
     *
     * @return \Illuminate\View\View
     */
    public function absentCreate()
    {   
        return view('user.attendance.absence');
    } 

    /**
     * 欠席登録
     *
     * @param  \App\Http\Requests\User\AttendanceRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function absentStore(AttendanceRequest $request)
    {
        $input = Attendance::inputUpdate($request);
        $existJudgement = Attendance::existJudgement($this->attendance, $input['date']);
        Attendance::attendanceSave($input, $existJudgement, $this->attendance);
        return redirect()->route('attendance.index');
    }

    /**
     * 修正申請画面表示
     *
     * @return \Illuminate\View\View
     */
    public function modifyCreate()
    {
        return view('user.attendance.modify');
    }

    /**
     * 修正登録
     *
     * @param  \App\Http\Requests\User\AttendanceRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function modifyStore(AttendanceRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $existJudgement = Attendance::existJudgement($this->attendance, $input['date']);
        Attendance::attendanceSave($input, $existJudgement, $this->attendance);
        return redirect()->route('attendance.index');
    }

    /**
     * マイページ画面
     *
     * @return \Illuminate\View\View
     */
    public function showMypage()
    {
        $user_id = Auth::id();
        $attendances = $this->attendance->where('user_id', $user_id)
                                        ->orderBy('date', 'desc')->get();
        $end_time_count = $this->attendance->where('user_id', $user_id)
                                           ->whereNotNull('end_time')
                                           ->count();
        $absent_count = $this->attendance->where('user_id', $user_id)
                                         ->whereNotNull('end_time')
                                         ->whereNotNull('absent_content')
                                         ->count();
        $attendance_count = $end_time_count - $absent_count;
        $study_time = 0;
        foreach ($attendances as $attendance) {
            if (!$attendance->absent_content) {
                if ($attendance->end_time) {
                    $study_time += $attendance->end_time->diffInHours($attendance->start_time);
                }
            }
        }
        return view('user.attendance.mypage', compact('attendances', 'attendance_count', 'study_time'));
    }
}
