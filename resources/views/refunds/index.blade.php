@extends('layouts.default')
@section('title', '物资退库主页')

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
    <li role="presentation" class="active"><a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">物资列表</a></li>
    <li role="presentation"><a href="#tab2" aria-controls="profile" role="tab" data-toggle="tab">列表修改痕迹</a></li>
  </ul>
<div class="tab-content">
<br />
<div id="tab1" role="tabpanel" class="tab-pane active">
  @hasanyrole('项目经理|高级管理员|站长')
<a class="btn btn-success" href="{{route('refunds.create')}}" role="button">添加&nbsp;<b>+</b></a>
<a class="btn btn-primary" href="{{route('refunds.export')}}" role="button">导出退库物资EXCEL表格</a>
<a class="btn btn-primary" href="{{route('refunds.exportdetails')}}" role="button">导出退库物资详情EXCEL表格</a>
<form action={{route('refunds.index')}} method="get" class="form-inline" style='display:inline-block;margin-left:5%;'>
  <div class="form-group">
    <input type="text" name="query" class="form-control" placeholder="Search" value="<?php echo isset($_GET['query'])?$_GET['query']:''; ?>">
  </div>
  <button type="submit" class="btn btn-default">搜索</button>
</form>
@endhasanyrole
<span  class="pull-right" style="font-size: 18px;">总共查询到 {{$refunds['data']->total()}} 行数据</span>

<div class="table-responsive">
  <table class="table table-hover table-striped table-bordered">
        <thead>
          <tr>
            <th>id</th>
            <th>{{ $refunds['title']->audit_report_name or ""}}</th>
            <th>{{ $refunds['title']->professional_room or ""}}</th>
            <th style="min-width:200px">{{ $refunds['title']->project_manager or ""}}</th>
            <th style="min-width:200px">{{ $refunds['title']->project_number or ""}}</th>
            <th style="min-width:200px">{{ $refunds['title']->publish_date or ""}}</th>
            <th style="min-width:200px">{{ $refunds['title']->audit_document_number or ""}}</th>
            <th style="min-width:200px">{{ $refunds['title']->audit_type or ""}}</th>
            <th>{{ $refunds['title']->project_type or ""}}</th>
            <th style="min-width:200px">{{ $refunds['title']->audit_company or ""}}</th>
            <th>{{ $refunds['title']->submit_cost or ""}}</th>
            <th>{{ $refunds['title']->validation_cost or ""}}</th>
            <th>{{ $refunds['title']->subtraction_cost or ""}}</th>
            <th>{{ $refunds['title']->subtraction_rate or ""}}</th>
            <th>{{ $refunds['title']->mterials_audit or ""}}</th>
            <th>{{ $refunds['title']->construction_should_refund or ""}}</th>
            <th>{{ $refunds['title']->thing_refund or ""}}</th>
            <th>{{ $refunds['title']->cash_refund or ""}}</th>
            <th style="min-width:200px">{{ $refunds['title']->direct_yes or ""}}</th>
            <th style="min-width:200px">{{ $refunds['title']->direct_no or ""}}</th>
            <th>{{ $refunds['title']->unrefund_cost or ""}}</th>
            <th style="min-width:300px">{{ $refunds['title']->reason or ""}}</th>
            <th>{{ $refunds['title']->Remarks or ""}}</th>


            <th>操作</th>

          </tr>
        </thead>
        <tbody>
          @foreach ($refunds['data'] as $data)
          <tr>
            <th class="id" scope="row">{{$data->id or ""}}</th>
            <td title="{{$data->audit_report_name or ""}}" style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"class="audit_report_name">{{$data->audit_report_name or ""}}</td>
            <td class="professional_room">{{$data->professional_room or ""}}</td>
            <td class="project_manager">{{$data->project_manager or ""}}</td>
            <td class="project_number">{{$data->project_number or ""}}</td>
            <td class="publish_date">{{$data->publish_date or ""}}</td>
            <td class="audit_document_number">{{$data->audit_document_number or ""}}</td>
            <td class="audit_type">{{$data->audit_type or ""}}</td>
            <td class="project_type">{{$data->project_type or ""}}</td>
            <td class="audit_company">{{$data->audit_company or ""}}</td>
            <td class="submit_cost">{{$data->submit_cost or ""}}</td>
            <td class="validation_cost">{{$data->validation_cost or ""}}</td>
            <td class="subtraction_cost">{{$data->subtraction_cost or ""}}</td>
            <td class="subtraction_rate">{{$data->subtraction_rate or ""}}</td>
            <td class="mterials_audit">{{$data->mterials_audit or ""}}</td>
            <td class="construction_should_refund">{{$data->construction_should_refund or ""}}</td>
            <td class="thing_refund">{{$data->thing_refund or ""}}</td>
            <td class="cash_refund">{{$data->cash_refund or ""}}</td>
            <td class="direct_yes">{{$data->direct_yes or ""}}</td>
            <td class="direct_no">{{$data->direct_no or ""}}</td>
            <td class="unrefund_cost">{{$data->unrefund_cost or ""}}</td>
            <td style="max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" class="reason" title="{{$data->reason or ""}}">{{$data->reason or ""}}</td>
            <td style="max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" class="Remarks" title="{{$data->Remarks or ""}}">{{$data->Remarks or ""}}</td>


            <td class="action">
              @if(Auth::user()->hasAnyRole('高级管理员|站长'))
              <a class="update" title="编辑" onclick="tableeditanddelete.update(this)" href="#" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp;&nbsp;<a data-whatever="{{$data->id}}" data-toggle="modal" data-target="#myModal" title="删除" id="delete" href="javascript:;" role="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>&nbsp;&nbsp;<a class="update" title="对应物资详情" href="{{route('refunds.refundsdetail',$data->id)}}" role="button"><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span></a>
              @elseif(Auth::user()->hasAnyRole('项目经理'))
                  @can('updateanddestroy', $data)
                  <a class="update" title="编辑" onclick="tableeditanddelete.update(this)" href="javascript:;" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp;&nbsp;<a data-whatever="{{$data->id}}" data-toggle="modal" data-target="#myModal" title="删除" id="delete" href="javascript:;" role="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>&nbsp;&nbsp;<a class="update" title="对应物资详情" href="{{route('refunds.refundsdetail',$data->id)}}" role="button"><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span></a>
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
{!! $refunds['data']->links() !!}
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

var tem=["id","audit_report_name","professional_room","project_manager","project_number","publish_date","audit_document_number","audit_type","project_type","audit_company","submit_cost","validation_cost","subtraction_cost","subtraction_rate","mterials_audit","construction_should_refund","thing_refund","cash_refund","direct_yes","direct_no","unrefund_cost","reason","Remarks"];
var tableeditanddelete= new tableeditanddelete(tem,'refunds/rowupdate/',2);
// window.tem={};


$(document).ready(function(){
window.Echo.channel('all')
    .listen('ChangeOrder', function(e){

      $("#totalcontainer").prepend('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+e.name+e.mes+e.order_number+'</div>');

    });


//模态框显现时传递数据，改变form的action路由值
    $('#myModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var recipient = button.data('whatever'); // Extract info from data-* attributes
      $(this).find("#delete").attr('action','/audit_navigation/refunds/'+recipient);
  });

})





</script>
@stop
