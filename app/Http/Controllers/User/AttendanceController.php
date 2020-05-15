<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AttendanceRequest;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    private $attendance;

    public function __construct(Attendance $attendance)
    {
        $this->middleware('auth');
        $this->attendance = $attendance;
    }

    /**
     * 勤怠登録面覧
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $status = '出社時間登録';
        $existJudgement = Attendance::existJudgement($this->attendance, date('Y/m/d'));
        if (!$existJudgement) {
            $state = '出社時間登録';
        } else {
            $hoge = $this->attendance->where('user_id', Auth::id())
                                     ->where('date', date('Y/m/d'))->first();
            if ($hoge->absent_content) {
                $status = '欠席';
            } else {
                if ($hoge->end_time) {
                    $status = '退社済み';
                } else {
                    if ($hoge->start_time) {
                        $status = '退社時間登録';
                    }
                }
            }
        }
        return view('user.attendance.index', compact('status'));
    }

    /**
     * 欠席新規作成
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */

    public function absentCreate()
    {   
        return view('user.attendance.absence');
    } 

    /**
     * 欠席登録のバリデーションと保存
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */

    public function absentStore(AttendanceRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $input['date'] = date('Y/m/d');
        $existJudgement = Attendance::existJudgement($this->attendance, $input['date']);
        if ($existJudgement) {
            $this->attendance->where('user_id', $input['user_id'])
                             ->where('date', $input['date'])
                             ->first()->fill($input)->save();
        } else {
            $this->attendance->fill($input)->save();
        }
        return redirect()->route('attendance.index');
    }

    /**
     * 修正新規作成
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */

    public function modifyCreate()
    {
        return view('user.attendance.modify');
    }

    /**
     * 修正登録のバリデーションと保存
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */

    public function modifyStore(AttendanceRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $existJudgement = Attendance::existJudgement($this->attendance, $input['date']);
        if ($existJudgement) {
            $this->attendance->where('user_id', $input['user_id'])
                             ->where('date', $input['date'])
                             ->first()->fill($input)->save();
        } else {
            $this->attendance->fill($input)->save();
        }
        return redirect()->route('attendance.index');
    }

    /**
     * マイページ画面
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */

    public function showMypage()
    {
        return view('user.attendance.mypage');
    }
}
