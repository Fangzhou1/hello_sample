@extends('layouts.default')

@section('title','帮助')
@section('content')
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
  <div class="panel-heading">
    <a class="btn btn-primary btn-sm" href="{{route('permissions.index')}}" role="button">返回</a>&nbsp&nbsp
    <span class="panel-title">添加权限</span>
  </div>
  <div class="panel-body">
  <form method="POST" action="{{route('permissions.store')}}">
      {{ csrf_field() }}
    <div class="form-group">
      <label for="order_number">权限名称</label>
      <input name="name" type="text" class="form-control" placeholder="Text input">
    </div>
    <div class="form-group">
      <label for="vendor_name">权限路由名</label>
      <input name="route" type="text" class="form-control" placeholder="Text input">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">权限组</label>
      <input name="guard_name" type="text" class="form-control" placeholder="Text input">
    </div>

    <button type="submit" class="btn btn-primary">新增权限</button>
  </form>
  </div>
</div>
</div>
@stop
