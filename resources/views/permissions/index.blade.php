@extends('layouts.default')
<script type="text/javascript" src="/js/tableeditanddelete.js"></script>
@section('title', '权限设置')

@section('content')
<div class="col-md-2">
@include('layouts.left')
</div>
<div class="col-md-10">

<div id="tab1" role="tabpanel" class="tab-pane active">
<a class="btn btn-success" href="{{route('permissions.create')}}" role="button">添加&nbsp;<b>+</b></a>
<span  class="pull-right" style="font-size: 18px;">总共查询到{{count($permissions)}}行数据</span>
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
            <td class="id">{{$data->id}}</td>
            <td class="name">{{$data->name}}</td>
            <td class="route">{{$data->route}}</td>
            <td class="guard_name">{{$data->guard_name}}</td>
            <td class="action">
              <a class="update" title="编辑" onclick="tableeditanddelete.update(this)" href="javascript:;" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp
              <a data-whatever="{{$data->id}}" data-toggle="modal" data-target="#myModal" title="删除" id="delete" href="javascript:;" role="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
              </td>
          </tr>

            @endforeach

        </tbody>
      </table>
</div>
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">警告</h4>
      </div>
      <div class="modal-body">
        你确定删除吗？
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <form id="delete" method="POST" action="" style="display:inline-block">
          <div id="iputwrap">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
          <input class="btn btn-primary" type="submit" value="确定">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
var tem=["id","name","route","guard_name"];
var tableeditanddelete= new tableeditanddelete(tem,'permissions/rowupdate/');

$(document).ready(function(){
  $('#myModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var recipient = button.data('whatever'); // Extract info from data-* attributes
    $(this).find("#delete").attr('action','permissions/'+recipient);
});
})
</script>
@stop
