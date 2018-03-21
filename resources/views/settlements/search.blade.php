@extends('layouts.default')
<script type="text/javascript" src="/js/tableeditanddelete.js"></script>
@section('title', '结算审计主页')

@section('content')
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
<a class="btn btn-success" href="{{route('settlements.create')}}" role="button">添加&nbsp;<b>+</b></a>
<a class="btn btn-primary" href="{{route('settlements.export')}}" role="button">导出EXCEL表格</a>
@endhasanyrole
<span  class="pull-right" style="font-size: 18px;">总共查询到 {{$settlements['data']->total()}} 行数据</span>
<div class="table-responsive">
  <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>id</th>
            <th>{{ $settlements['title']->order_number or ""}}</th>
            <th style="min-width:300px">{{ $settlements['title']->vendor_name or ""}}</th>
            <th>{{ $settlements['title']->material_name or ""}}</th>
            <th>{{ $settlements['title']->material_type or ""}}</th>
            <th>{{ $settlements['title']->project_number or ""}}</th>
            <th style="min-width:200px">{{ $settlements['title']->project_name or ""}}</th>
            <th style="min-width:300px">{{ $settlements['title']->project_manager or ""}}</th>
            <th>{{ $settlements['title']->audit_progress or ""}}</th>
            <th>{{ $settlements['title']->audit_document_number or ""}}</th>
            <th>{{ $settlements['title']->audit_company or ""}}</th>
            <th style="min-width:350px">{{ $settlements['title']->order_description or ""}}</th>
            <th style="min-width:300px">{{ $settlements['title']->contract_number or ""}}</th>
            <th>{{ $settlements['title']->audit_number or ""}}</th>
            <th>{{ $settlements['title']->cost or ""}}</th>
            <th>{{ $settlements['title']->paid_cost or ""}}</th>
            <th>{{ $settlements['title']->mis_cost or ""}}</th>
            <th>{{ $settlements['title']->submit_cost or ""}}</th>
            <th>{{ $settlements['title']->validation_cost or ""}}</th>

            <th>操作</th>

          </tr>
        </thead>
        <tbody>
          @foreach ($settlements['data'] as $data)
          <tr>
            <th class="id" scope="row">{{$data->id or ""}}</th>
            <td class="order_number">{{$data->order_number or ""}}</td>
            <td class="vendor_name">{{$data->vendor_name or ""}}</td>
            <td class="material_name">{{$data->material_name or ""}}</td>
            <td class="material_type">{{$data->material_type or ""}}</td>
            <td class="project_number">{{$data->project_number or ""}}</td>
            <td class="project_name">{{$data->project_name or ""}}</td>
            <td class="project_manager">{{$data->project_manager or ""}}</td>
            <td class="audit_progress">{{$data->audit_progress or ""}}</td>
            <td class="audit_document_number">{{$data->audit_document_number or ""}}</td>
            <td class="audit_company">{{$data->audit_company or ""}}</td>
            <td class="order_description">{{$data->order_description or ""}}</td>
            <td class="contract_number">{{$data->contract_number or ""}}</td>
            <td class="audit_number">{{$data->audit_number or ""}}</td>
            <td class="cost">{{$data->cost or ""}}</td>
            <td class="paid_cost">{{$data->paid_cost or ""}}</td>
            <td class="mis_cost">{{$data->mis_cost or ""}}</td>
            <td class="submit_cost">{{$data->submit_cost or ""}}</td>
            <td class="validation_cost">{{$data->validation_cost or ""}}</td>

            <td class="action">
              @hasanyrole('项目经理|高级管理员|站长')
              <a class="update" title="编辑" onclick="tableeditanddelete.update(this)" href="javascript:;" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp<a data-whatever="{{$data->id}}" data-toggle="modal" data-target="#myModal" title="删除" id="delete" href="javascript:;" role="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
          @else
          你无权限操作
          @endhasanyrole
            </td>

          </tr>

            @endforeach

        </tbody>
      </table>
</div>
{!! $settlements['data']->links() !!}
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
<div style="text-align: center;color:gray;"><span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></div>
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

var tem=["id","order_number","vendor_name","material_name","material_type","project_number","project_name","project_manager","audit_progress","audit_document_number","audit_company","order_description","contract_number","audit_number","cost","paid_cost","mis_cost","submit_cost","validation_cost"];
var tableeditanddelete= new tableeditanddelete(tem,'/settlements/rowupdate/');
//window.tem={};


$(document).ready(function(){
window.Echo.channel('all')
    .listen('ChangeOrder', (e) => {

      $("#totalcontainer").prepend('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+e.name+e.mes+e.order_number+'的订单。'+e.mes2+'</div>');

    });



    $('#myModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var recipient = button.data('whatever'); // Extract info from data-* attributes
      $(this).find("#delete").attr('action','/settlements/'+recipient);
})


});
</script>
@stop
