@extends('layouts.default')

@section('title','分配权限')
@section('content')
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
  <div class="panel-heading">
    <a class="btn btn-primary btn-sm" href="{{route('roles.index')}}" role="button">返回</a>&nbsp&nbsp
    <span class="panel-title">为<b>“{{$role->name}}”</b>角色为分配权限</span>
  </div>
  <div class="panel-body">
  <form method="POST" action="{{route('roles.permissionstorole',$role->id)}}">
      {{ csrf_field() }}
      @foreach ($permission as $data)
      <div class="checkbox">
        <label class="checkbox-inline col-md-3">
          <input type="checkbox" value="{{$data->name}}"  name="permission[]" {{$role->hasPermissionTo($data->name)?"checked":""}}> {{$data->name}}
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
