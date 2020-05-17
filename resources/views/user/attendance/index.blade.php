@extends ('common.user')
@section ('content')

<h2 class="brand-header">勤怠登録</h2>

<div class="main-wrap">

  <div id="clock" class="light">
    <div class="display">
      <div class="weekdays"></div>
      <div class="today"></div>
      <div class="digits"></div>
    </div>
  </div>
  <div class="button-holder">
  @if ($status === '欠席' || $status === '退社済み')
    <a class="button disabled" id="register-attendance">{{ $status }}</a>
  @elseif ($status === '退社時間登録')
    <a class="button" id="register-attendance" href=#openModal>{{ $status }}</a>
  @else
    <a class="button start-btn" id="register-attendance" href=#openModal>{{ $status }}</a>
  @endif
  </div>
  <ul class="button-wrap">
    <li>
      <a class="at-btn absence" href="{{ route('attendance.absentCreate') }}">欠席登録</a>
    </li>
    <li>
      <a class="at-btn modify" href="{{ route('attendance.modifyCreate') }}">修正申請</a>
    </li>
    <li>
      <a class="at-btn my-list" href="{{ route('attendance.mypage') }}">マイページ</a>
    </li>
  </ul>
</div>

<div id="openModal" class="modalDialog">
  <div>
  @if ($status === '出社時間登録')
    <div class="register-text-wrap"><p>12:38 で出社時間を登録しますか？</p></div>
    <div class="register-btn-wrap">
      {!! Form::open(['route' => 'attendance.timeStore', 'method' =>'POST']) !!}
        {!! Form::input('hidden', 'start_time', '2019-07-03 12:38:41', ['id' => 'date-time-target']) !!}
        <a href="#close" class="cancel-btn">Cancel</a>
        {!! Form::input('submit', '', 'Yes', ['class' => 'yes-btn']) !!}
      {!! Form::close() !!}
    </div>
  @else
    <div class="register-text-wrap"><p>12:38 で退社時間を登録しますか？</p></div>
    <div class="register-btn-wrap">
      {!! Form::open(['route' => 'attendance.timeStore', 'method' =>'POST']) !!}
        {!! Form::input('hidden', 'end_time', '2019-07-03 12:38:41', ['id' => 'date-time-target']) !!}
        <a href="#close" class="cancel-btn">Cancel</a>
        {!! Form::input('submit', '', 'Yes', ['class' => 'yes-btn']) !!}
      {!! Form::close() !!}
    </div>
  @endif
  </div>
</div>

@endsection
