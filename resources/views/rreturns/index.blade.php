@extends('layouts.default')
@section('title', '决算审计主页')

@section('content')
<script type="text/javascript" src="/js/tableeditanddelete.js"></script>
<!-- <div class="flash-message">
  <p class="alert alert-dismissible alert-info">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    adssadsadsadasdsadsadsad
  </p>
</div> -->
<div class="col-md-2">
@include('layouts.left')
</div>
<div class="col-md-10">
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">审计列表</a></li>
    <li role="presentation"><a href="#tab2" aria-controls="profile" role="tab" data-toggle="tab">列表修改痕迹</a></li>
  </ul>
<div class="tab-content">
<br />
<div id="tab1" role="tabpanel" class="tab-pane active">
  @hasanyrole('项目经理|高级管理员|站长')
<a class="btn btn-success" href="{{route('rreturns.create')}}" role="button">添加&nbsp;<b>+</b></a>
<a class="btn btn-primary" href="{{route('rreturns.export')}}" role="button">导出EXCEL表格</a>
<form action={{route('rreturns.index')}} method="get" class="form-inline" style='display:inline-block;margin-left:20%;'>
  <div class="form-group">
    <input type="text" name="query" class="form-control" placeholder="Search" value="<?php echo isset($_GET['query'])?$_GET['query']:''; ?>">
  </div>
  <button type="submit" class="btn btn-default">搜索</button>
</form>
@endhasanyrole
<span  class="pull-right" style="font-size: 18px;">总共查询到 {{$rreturns['data']->total()}} 行数据</span>

<div class="table-responsive">
  <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>id</th>
            <th style="min-width:200px">{{ $rreturns['title']->project_duration or ""}}</th>
            <th>{{ $rreturns['title']->project_number or ""}}</th>
            <th style="min-width:320px">{{ $rreturns['title']->project_name or ""}}</th>
            <th style="min-width:150px">{{ $rreturns['title']->project_manager or ""}}</th>
            <th style="min-width:150px">{{ $rreturns['title']->audit_progress or ""}}</th>
            <th style="min-width:150px">{{ $rreturns['title']->audit_document_number or ""}}</th>
            <th>{{ $rreturns['title']->audit_company or ""}}</th>
            <th>{{ $rreturns['title']->is_needsaudit or ""}}</th>
            <th>{{ $rreturns['title']->is_canaudit or ""}}</th>
            <th>{{ $rreturns['title']->audit_number or ""}}</th>
            <th style="min-width:320px">{{ $rreturns['title']->remarks or ""}}</th>

            <th>操作</th>

          </tr>
        </thead>
        <tbody>
          @foreach ($rreturns['data'] as $data)
          <tr>
            <th class="id" scope="row">{{$data->id or ""}}</th>
            <td class="project_duration">{{$data->project_duration or ""}}</td>
            <td class="project_number">{{$data->project_number or ""}}</td>
            <td class="project_name">{{$data->project_name or ""}}</td>
            <td class="project_manager">{{$data->project_manager or ""}}</td>
            <td class="audit_progress">{{$data->audit_progress or ""}}</td>
            <td class="audit_document_number">{{$data->audit_document_number or ""}}</td>
            <td class="audit_company">{{$data->audit_company or ""}}</td>
            <td class="is_needsaudit">{{$data->is_needsaudit or ""}}</td>
            <td class="is_canaudit">{{$data->is_canaudit or ""}}</td>
            <td class="audit_number">{{$data->audit_number or ""}}</td>
            <td class="remarks">{{$data->remarks or ""}}</td>


            <td class="action">
              @if(Auth::user()->hasAnyRole('高级管理员|站长'))
              <a class="update" title="编辑" onclick="tableeditanddelete.update(this)" href="#" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp;<a data-whatever="{{$data->id}}" data-toggle="modal" data-target="#myModal" title="删除" id="delete" href="javascript:;" role="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
              @elseif(Auth::user()->hasAnyRole('项目经理'))
                  @can('updateanddestroy', $data)
                  <a class="update" title="编辑" onclick="tableeditanddelete.update(this)" href="javascript:;" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp;<a data-whatever="{{$data->id}}" data-toggle="modal" data-target="#myModal" title="删除" id="delete" href="javascript:;" role="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                  @else
                  你无权限操作
                  @endcan
              @else
              你无权限操作
              @endif
            </td>


          </tr>

            @endforeach

        </tbody>
      </table>
</div>
{!! $rreturns['data']->links() !!}
</div>


<div id="tab2" role="tabpane1" class="tab-pane">
  @foreach ($traces as $key=>$data)
<button style="width:50%;" class="btn btn-success btn-lg center-block superlong" type="button" data-toggle="collapse" data-target="#collapseExample{{$loop->iteration}}" aria-expanded="false" aria-controls="collapseExample">
{{$key}}的痕迹
</button>
<div class="collapse" id="collapseExample{{$loop->iteration}}">
  <div class="well">
    @foreach ($data as $value)
    <p>{{$value->content}}</p>
    @endforeach
  </div>
</div>
@if (!$loop->last)
<div style="text-align: center;color:gray;"><span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></div>
@endif
@endforeach
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

var tem=["id","project_duration","project_number","project_name","project_manager","audit_progress","audit_document_number","audit_company","is_needsaudit","is_canaudit","audit_number","remarks"];
var tableeditanddelete= new tableeditanddelete(tem,'rreturns/rowupdate/');
// window.tem={};


$(document).ready(function(){
window.Echo.channel('all')
    .listen('ChangeOrder', function(e){

      $("#totalcontainer").prepend('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+e.name+e.mes+e.order_number+'的订单</div>');

    });


//模态框显现时传递数据，改变form的action路由值
    $('#myModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var recipient = button.data('whatever'); // Extract info from data-* attributes
      $(this).find("#delete").attr('action','rreturns/'+recipient);
  });

})

// function update(obj)
// {
//     if(!$.isEmptyObject(tem))
//     {
//       cancel(obj)
//     }
//
//
//     $(obj).parents('tr').addClass("editable");
//
//     tem={"project_duration":$(obj).parents('tr').find(".project_duration").text(),
//     "project_number":$(obj).parents('tr').find(".project_number").text(),
//     "project_name":$(obj).parents('tr').find(".project_name").text(),
//     "project_manager":$(obj).parents('tr').find(".project_manager").text(),
//     "audit_progress":$(obj).parents('tr').find(".audit_progress").text(),
//     "audit_document_number":$(obj).parents('tr').find(".audit_document_number").text(),
//     "audit_company":$(obj).parents('tr').find(".audit_company").text(),
//     "is_needsaudit":$(obj).parents('tr').find(".is_needsaudit").text(),
//     "is_canaudit":$(obj).parents('tr').find(".is_canaudit").text(),
//     "audit_number":$(obj).parents('tr').find(".audit_number").text(),
//     "remarks":$(obj).parents('tr').find(".remarks").text(),
//     "id":$(obj).parents('tr').find(".id").text()
//   }
//     $(obj).parents('table').wrapAll('<form method="POST" action="/rreturns/rowupdate/'+tem.id+'">');
//     $(obj).parents('tr').find(".id").append('<input type="hidden" name="_token" value="">');
//     $(obj).parents('tr').find(".project_duration").html('<input type="text" name="project_duration" class="form-control input-sm" value='+tem.project_duration+'>');
//     $(obj).parents('tr').find(".project_number").html('<input type="text" name="project_number" class="form-control input-sm" value='+tem.project_number+'>');
//     $(obj).parents('tr').find(".project_name").html('<input type="text" name="project_name" class="form-control input-sm" value='+tem.project_name+'>');
//     $(obj).parents('tr').find(".project_manager").html('<input type="text" name="project_manager" class="form-control input-sm" value='+tem.project_manager+'>');
//     $(obj).parents('tr').find(".audit_progress").html('<input type="text" name="audit_progress" class="form-control input-sm" value='+tem.audit_progress+'>');
//     $(obj).parents('tr').find(".audit_document_number").html('<input type="text" name="audit_document_number" class="form-control input-sm" value='+tem.audit_document_number+'>');
//     $(obj).parents('tr').find(".audit_company").html('<input type="text" name="audit_company" class="form-control input-sm" value='+tem.audit_company+'>');
//     $(obj).parents('tr').find(".is_needsaudit").html('<input type="text" name="is_needsaudit" class="form-control input-sm" value='+tem.is_needsaudit+'>');
//     $(obj).parents('tr').find(".is_canaudit").html('<input type="text" name="is_canaudit" class="form-control input-sm" value='+tem.is_canaudit+'>');
//     $(obj).parents('tr').find(".audit_number").html('<input type="text" name="audit_number" class="form-control input-sm" value='+tem.audit_number+'>');
//     $(obj).parents('tr').find(".remarks").html('<input type="text" name="remarks" class="form-control input-sm" value='+tem.remarks+'>');
//     $(obj).parents('tr').find(".action").html('<input class="btn btn-default btn-xs" type="submit" value="提交">&nbsp;<a onclick="cancel(this)" class="btn btn-default btn-xs" href="javascript:;" role="button">取消</a>');
//
//
//   };
//   function cancel(obj)
//   {
//
//
//     $(obj).parents('table').unwrap('form');
//     $(obj).parents('tbody').find('.editable').find(".id").html(tem.id);
//     $(obj).parents('tbody').find('.editable').find(".project_duration").html(tem.project_duration);
//     $(obj).parents('tbody').find('.editable').find(".project_number").html(tem.project_number);
//     $(obj).parents('tbody').find('.editable').find(".project_name").html(tem.project_name);
//     $(obj).parents('tbody').find('.editable').find(".project_manager").html(tem.project_manager);
//     $(obj).parents('tbody').find('.editable').find(".audit_progress").html(tem.audit_progress);
//     $(obj).parents('tbody').find('.editable').find(".audit_document_number").html(tem.audit_document_number);
//     $(obj).parents('tbody').find('.editable').find(".audit_company").html(tem.audit_company);
//     $(obj).parents('tbody').find('.editable').find(".is_needsaudit").html(tem.is_needsaudit);
//     $(obj).parents('tbody').find('.editable').find(".is_canaudit").html(tem.is_canaudit);
//     $(obj).parents('tbody').find('.editable').find(".audit_number").html(tem.audit_number);
//     $(obj).parents('tbody').find('.editable').find(".remarks").html(tem.remarks);
//
//     $(obj).parents('tbody').find('.editable').find(".action").html('<a class="update" title="编辑" onclick="update(this)" href="javascript:;" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;<a data-whatever="'+tem.id+'" data-toggle="modal" data-target="#myModal" title="删除" id="delete" href="javascript:;" role="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>');
//
//     $(obj).parents('tbody').find(".editable").removeClass("editable");
//     tem={};
//
//
//   }



</script>
@stop
