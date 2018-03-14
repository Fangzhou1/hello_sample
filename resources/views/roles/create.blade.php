@extends('layouts.default')

@section('title','帮助')
@section('content')
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
  <div class="panel-heading">
    <a class="btn btn-primary btn-sm" href="{{route('roles.index')}}" role="button">返回</a>&nbsp&nbsp
    <span class="panel-title">添加角色</span>
  </div>
  <div class="panel-body">
  <form method="POST" action="{{route('roles.store')}}">
      {{ csrf_field() }}
    <div class="form-group">
      <label for="name">角色名称</label>
      <input name="name" type="text" class="form-control" placeholder="Text input">
    </div>
    <div class="form-group">
      <label for="guard_name">角色组</label>
      <input name="guard_name" type="text" class="form-control" placeholder="Text input">
    </div>

    <button type="submit" class="btn btn-primary">新增角色</button>
  </form>
  </div>
</div>
</div>
@stop
