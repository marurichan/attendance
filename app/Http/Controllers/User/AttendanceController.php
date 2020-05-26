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
    public function storeTime(Request $request)
    {
        $input = $this->attendance->addColumn($request);
        $this->attendance->saveAttendance($input);
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
        $input = $this->attendance->addColumn($request);
        $this->attendance->saveAttendance($input);
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
        $this->attendance->saveAttendance($input);
        return redirect()->route('attendance.index');
    }

    /**
     * マイページ画面
     *
     * @return \Illuminate\View\View
     */
    public function showMypage()
    {
        $userId = Auth::id();
        $attendances = $this->attendance->where('user_id', $userId)
                                        ->orderBy('date', 'desc')->get();
        $inAttendances = $attendances->where('end_time', '!=', null)
                                    ->where('absent_content', null);
        $attendanceCount = $inAttendances->count();
        $studyTime = 0;
        foreach ($inAttendances as $inAttendance) {
            $studyTime += $inAttendance->end_time->diffInHours($inAttendance->start_time);
        }
        return view('user.attendance.mypage', compact('attendances', 'attendanceCount', 'studyTime'));
    }
}
