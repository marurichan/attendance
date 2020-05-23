<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Attendance\ModifyRequest;
use App\Http\Requests\User\Attendance\AbsentRequest;
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
        $status = $this->attendance->getStatus($this->attendance->existJudgement(today()));
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
        $input = $this->attendance->inputUpdate($request);
        $existJudgement = $this->attendance->existJudgement($input['date']);
        $this->attendance->attendanceSave($input, $existJudgement);
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
    public function absentStore(AbsentRequest $request)
    {
        $input = $this->attendance->inputUpdate($request);
        $existJudgement = $this->attendance->existJudgement($input['date']);
        $this->attendance->attendanceSave($input, $existJudgement);
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
    public function modifyStore(ModifyRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $existJudgement = $this->attendance->existJudgement($input['date']);
        $this->attendance->attendanceSave($input, $existJudgement);
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
