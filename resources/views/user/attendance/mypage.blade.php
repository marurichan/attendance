@extends ('common.user')
@section ('content')

<h2 class="brand-header">マイページ</h2>

<div class="main-wrap">
  <div class="btn-wrapper">
    <div class="my-info day-info">
      <p>学習経過日数</p>
      <div class="study-hour-box clearfix">
        <div class="userinfo-box"><img src={{ Auth::user()->avatar }}></div>
        <p class="study-hour"><span>{{ $attendanceCount }}</span>日</p>
      </div>
    </div>
    <div class="my-info">
      <p>累計学習時間</p>
      <div class="study-hour-box clearfix">
        <div class="userinfo-box"><img src={{ Auth::user()->avatar }}></div>
        <p class="study-hour"><span>{{ $studyTime }}</span>時間</p>
      </div>
    </div>
  </div>
  <div class="content-wrapper table-responsive">
    <table class="table">
      <thead>
        <tr class="row">
          <th class="col-xs-2">date</th>
          <th class="col-xs-3">start time</th>
          <th class="col-xs-3">end time</th>
          <th class="col-xs-2">state</th>
          <th class="col-xs-2">request</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($attendances as $attendance)
      <tr class="row @if ($attendance->absent_content) absent-row @endif ">
        <td class="col-xs-2">{{ $attendance->date->format('m/d（D）') }}</td>
          <td class="col-xs-3">{{ $attendance->start_time ? $attendance->start_time->format('H:i'): '-' }}</td>
          <td class="col-xs-3">{{ $attendance->end_time ? $attendance->end_time->format('H:i'): '-' }}</td>
        @if ($attendance->absent_content !== null)
          <td class="col-xs-2">欠席</td>
        @elseif ($attendance->end_time !== null)
          <td class="col-xs-2">出社</td>
        @elseif($attendance->start_time !== null)
          <td class="col-xs-2">研修中</td>
        @else
          <td class="col-xs-2">-</td>
        @endif
          <td class="col-xs-2">{{ $attendance->modify_content ? '申請中': '-' }}</td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection

