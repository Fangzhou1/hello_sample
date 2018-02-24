@extends('layouts.default')

@section('title','注册')
@section('content')
<div class="col-md-offset-2 col-md-8">
<div class="panel panel-default">
  <div class="panel-heading">
    <h5>注册</h5>
  </div>


  <div class="panel-body">
    @include('shared._errors')
    <form method="POST" action="{{ route('users.store') }}">
      {{ csrf_field() }}
        <div class="form-group">
          <label for="name">名称：</label>
          <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>

        <div class="form-group">
          <label for="email">邮箱：</label>
          <input type="text" name="email" class="form-control" value="{{ old('email') }}">
        </div>

        <div class="form-group">
          <label for="email">验证码：</label>
          <input id="captcha" class="form-control" name="captcha" >
          <img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
        </div>

        <div class="form-group">
          <label for="password">密码：</label>
          <input type="password" name="password" class="form-control" value="{{ old('password') }}">
        </div>

        <div class="form-group">
          <label for="password_confirmation">确认密码：</label>
          <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
        </div>

        <button type="submit" class="btn btn-primary btn-block  ">注册</button>
    </form>
  </div>
</div>
</div>

@stop
