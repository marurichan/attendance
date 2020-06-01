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
        $status = $this->attendance->getStatus();
        return view('user.attendance.index', compact('status'));
    }

    /**
     * 勤怠登録
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeStartTime(Request $request)
    {
        $userId = Auth::id();
        $inputs = $this->attendance->addColumn($request, $userId);
        $this->attendance->startSaveAttendance($inputs, $userId, $inputs['date']);
        return redirect()->route('attendance.index');
    }

    /**
     * 勤怠登録
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeEndTime(Request $request)
    {
        $userId = Auth::id();
        $inputs = $this->attendance->addColumn($request, $userId);
        $this->attendance->endSaveAttendance($inputs, $userId, $inputs['date']);
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
        $userId = Auth::id();
        $inputs = $this->attendance->addColumn($request, $userId);
        $this->attendance->saveAttendance($inputs, $userId, $inputs['date']);
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
        $userId = Auth::id();
        $inputs = $request->all();
        $inputs['user_id'] = $userId;
        $this->attendance->saveAttendance($inputs, $userId, $inputs['date']);
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
        $attendances = $this->attendance->getUserAttendances($userId);
        $inAttendances = $attendances->where('end_time', '!=', null)
                                     ->where('absent_content', null);
        $attendanceCount = $inAttendances->count();
        $studyTime = 0;
        foreach ($inAttendances as $inAttendance) {
            $studyTime += $inAttendance->calcStudyTime();
        }
        return view('user.attendance.mypage', compact('attendances', 'attendanceCount', 'studyTime'));
    }
}
