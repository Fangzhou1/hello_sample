@extends('layouts.default')
@section('title', '更新个人资料')

@section('content')
<div class="col-md-offset-2 col-md-8">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5>更新个人资料</h5>
    </div>
      <div class="panel-body">

        @include('shared._errors')
        @include('shared._messages')


        <form method="POST" action="{{ route('users.update', $user->id )}}" enctype="multipart/form-data">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}



            <div class="form-group">
              <label for="name">名称：</label>
              <input type="text" name="name" class="form-control" value="{{ $user->name }}">
            </div>

            <div class="form-group">
              <label for="email">邮箱：</label>
              <input type="text" name="email" class="form-control" value="{{ $user->email }}" disabled>
            </div>


            <div class="form-group">
              <label for="introduction">简介：</label>
              <textarea class="form-control" rows="3" value="{{ $user->introduction }}" name="introduction"></textarea>
              </div>

              <div class="form-group">
                 <label for="avatar">头像：</label>
                 <input type="file" id="exampleInputFile" name="avatar">
                 <p class="help-block">点击选择图片上传头像</p>
               </div>

            <div class="form-group">
              <label for="password">密码：</label>
              <input type="password" name="password" class="form-control" value="{{ old('password') }}">
            </div>

            <div class="form-group">
              <label for="password_confirmation">确认密码：</label>
              <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
            </div>

            <button type="submit" class="btn btn-primary">更新</button>
        </form>
    </div>
  </div>
</div>
@stop
