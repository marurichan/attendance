<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('admin.attendance.index');
    }

    public function show($user_id)
    {
        return view('admin.attendance.user');
    }

    public function create($user_id)
    {
        return view('admin.attendance.create');
    }

    public function edit($user_id)
    {
        return view('admin.attendance.edit');
    }
}
