@extends ('common.user')
@section ('content')

<h2 class="brand-header">マイページ</h2>

<div class="main-wrap">
  <div class="btn-wrapper">
    <div class="my-info day-info">
      <p>学習経過日数</p>
      <div class="study-hour-box clearfix">
        <div class="userinfo-box"><img src={{ Auth::user()->avatar }}></div>
        <p class="study-hour"><span>{{ $attendance_count }}</span>日</p>
      </div>
    </div>
    <div class="my-info">
      <p>累計学習時間</p>
      <div class="study-hour-box clearfix">
        <div class="userinfo-box"><img src={{ Auth::user()->avatar }}></div>
        <p class="study-hour"><span></span>時間</p>
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
      <tr class="row">
        <td class="col-xs-2">{{ $attendance->date->format('m/d（D）') }}</td>
        @if ($attendance->start_time)
          <td class="col-xs-3">{{ $attendance->start_time->format('H:i') }}</td>
        @else
          <td class="col-xs-3">-</td>
        @endif
        @if ($attendance->end_time)
          <td class="col-xs-3">{{ $attendance->end_time->format('H:i') }}</td>
        @else
          <td class="col-xs-3">-</td>
        @endif
        @if ($attendance->absent_content)
          <td class="col-xs-2">欠席</td>
        @elseif ($attendance->end_time)
          <td class="col-xs-2">出社</td>
        @elseif($attendance->start_time)
          <td class="col-xs-2">研修中</td>
        @else
          <td class="col-xs-2">-</td>
        @endif
        @if ($attendance->modify_content)
          <td class="col-xs-2">申請中</td>
        @else
          <td class="col-xs-2">-</td>
        @endif
      </tr>
      <!-- <tr class="row">
        <td class="col-xs-2"></td>
        <td class="col-xs-3">08:29</td>
        <td class="col-xs-3">19:30</td>
        <td class="col-xs-2">出社</td>
        <td class="col-xs-2">-</td>
      </tr>
      <tr class="row absent-row">
        <td class="col-xs-2">07/02 (Tue)</td>
        <td class="col-xs-3">-</td>
        <td class="col-xs-3">-</td>
        <td class="col-xs-2">欠席</td>
        <td class="col-xs-2">-</td>
      </tr>
      <tr class="row">
        <td class="col-xs-2">07/03 (Wed)</td>
        <td class="col-xs-3">10:44</td>
        <td class="col-xs-3">19:37</td>
        <td class="col-xs-2">出社</td>
        <td class="col-xs-2">申請中</td>
      </tr>
      <tr class="row">
        <td class="col-xs-2">07/04 (Thr)</td>
        <td class="col-xs-3">08:52</td>
        <td class="col-xs-3">-</td>
        <td class="col-xs-2">研修中</td>
        <td class="col-xs-2">-</td>
      </tr> -->
      @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection

