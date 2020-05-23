@extends ('common.user')
@section ('content')

<h2 class="brand-header">欠席登録</h2>
<div class="main-wrap">
  <div class="container">
    {!! Form::open(['route' => 'attendance.absentStore', 'method' => 'POST']) !!}
      <div class="form-group @if ($errors->first('absent_content')) has-error @endif">
        {!! Form::textarea('absent_content', null, ['class' => 'form-control', 'placeholder' => '欠席理由を入力してください。']) !!}
        <span class="help-block">{{ $errors->first('absent_content') }}</span>
      </div>
        {!! Form::submit('登録', ['class' => 'btn btn-success pull-right']) !!}
      {!! Form::hidden('type', 'absent') !!}
    {!! Form::close() !!}
  </div>
</div>

@endsection

