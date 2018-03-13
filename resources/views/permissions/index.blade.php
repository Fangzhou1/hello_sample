@extends('layouts.default')
@section('title', '权限设置')

@section('content')
<div class="col-md-2">
@include('layouts.left')
</div>
<div class="col-md-10">

<div id="tab1" role="tabpanel" class="tab-pane active">
<a class="btn btn-success" href="{{route('permissions.create')}}" role="button">添加&nbsp;<b>+</b></a>
<span  class="pull-right" style="font-size: 18px;">总共查询到12行数据</span>
<div class="table-responsive">
  <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>id</th>
            <th>权限名称</th>
            <th>路由名称</th>
            <th>用户组</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($permissions as $data)
          <tr>
            <td >{{$data->id}}</td>
            <td >{{$data->name}}</td>
            <td >{{$data->route}}</td>
            <td >{{$data->guard_name}}</td>
            <td >
              <a class="update" title="编辑" onclick="update(this)" href="javascript:;" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp<a data-whatever="{{$data->id}}" data-toggle="modal" data-target="#myModal" title="删除" id="delete" href="javascript:;" role="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>
          </tr>

            @endforeach

        </tbody>
      </table>
</div>

</div>

</div>
@stop
