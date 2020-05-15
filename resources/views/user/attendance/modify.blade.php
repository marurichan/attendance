@extends ('common.user')
@section ('content')

<h2 class="brand-header">修正申請</h2>
<div class="main-wrap">
  <div class="container">
    {!! Form::open(['route' => 'attendance.modifyStore', 'method' => 'POST']) !!}
      <div class="form-group form-size-small @if ($errors->first('date')) has-error @endif">
        {!! Form::date('date', null, ['class' => 'form-control']) !!}
        <span class="help-block">{{ $errors->first('date') }}</span>
      </div>
      <div class="form-group @if ($errors->has('modify_content')) has-error @endif">
        {!! Form::textarea('modify_content', null, ['class' => 'form-control', 'placeholder' => '修正申請の内容を入力してください。']) !!}
        <span class="help-block">{{ $errors->first('modify_content') }}</span>
      </div>
      {!! Form::submit('申請', ['class' => 'btn btn-success pull-right']) !!}
      {!! Form::hidden('type', 'modify') !!}
    {!! Form::close() !!}
  </div>
</div>

@endsection

