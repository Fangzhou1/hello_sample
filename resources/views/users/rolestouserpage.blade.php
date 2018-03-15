@extends('layouts.default')

@section('title','分配角色')
@section('content')
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
  <div class="panel-heading">
    <a class="btn btn-primary btn-sm" href="{{route('users.usersactionindex')}}" role="button">返回</a>&nbsp&nbsp
    <span class="panel-title">为<b>“{{$user->name}}”</b>用户分配角色</span>
  </div>
  <div class="panel-body">
  <form method="POST" action="{{route('users.rolestouser',$user->id)}}">
      {{ csrf_field() }}
      @foreach ($roles as $data)
      <div class="radio">
        <label class="radio-inline col-md-3">
          <input type="radio" value="{{$data->name}}"  name="role" {{$user->hasRole($data->name)?"checked":""}}> {{$data->name}}
        </label>
      </div>
      @endforeach
    <div class="col-md-12"><hr></div>
    <div style="margin-top:10px;" class="col-md-12"><button type="submit" class="btn btn-primary">提交</button></div>
  </form>
</div>
</div>
</div>

@stop
