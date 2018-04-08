@extends('layouts.default')

@section('title', '结算审计主页')

@section('content')
<script type="text/javascript" src="/js/tableeditanddelete.js"></script>
<div class="col-md-2">
@include('layouts.left')
</div>
<div class="col-md-10">
<div class=row>
  <div class="col-md-4">
<a class="btn btn-primary" href="{{route('settlements.smsmail')}}" role="button">返回</a>
  </div>

    <div class="col-md-8">
  <div class="btn-group" role="group">
    <a class="btn btn-default {{!isset($querytoarray['order'])||$querytoarray['order']==1?'active':""}}" href="{{$current_url}}?name={{$querytoarray['name']}}&type={{$querytoarray['type']}}&order=1" role="button">按审计进度排序</a>
    <a class="btn btn-default {{isset($querytoarray['order'])&&$querytoarray['order']==2?'active':""}}" href="{{$current_url}}?name={{$querytoarray['name']}}&type={{$querytoarray['type']}}&order=2" role="button">按工程项目排序</a>
  </div>&nbsp;&nbsp;

  @if($querytoarray['type']==1)
  <a class="btn btn-primary" href="{{route('settlements.exportbytype')}}?project_manager={{$settlements['data']->first()->project_manager}}" role="button">导出EXCEL表格</a>
  @else
  <a class="btn btn-primary" href="{{route('settlements.exportbytype')}}?audit_company={{$settlements['data']->first()->audit_company}}" role="button">导出EXCEL表格</a>
  @endif

  <span  class="pull-right" style="font-size: 18px;">总共查询到 {{$settlements['data']->total()}} 行数据</span>
    </div>
</div>

<div class="table-responsive">
  <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>id</th>
            <th>{{ $settlements['title']->order_number }}</th>
            <th style="min-width:300px">{{ $settlements['title']->vendor_name }}</th>
            <th>{{ $settlements['title']->material_name }}</th>
            <th>{{ $settlements['title']->material_type }}</th>
            <th>{{ $settlements['title']->project_number }}</th>
            <th style="min-width:200px">{{ $settlements['title']->project_name }}</th>
            <th style="min-width:100px">{{ $settlements['title']->project_manager }}</th>
            <th>{{ $settlements['title']->audit_progress }}</th>
            <th>{{ $settlements['title']->audit_document_number }}</th>
            <th>{{ $settlements['title']->audit_company }}</th>
            <th style="min-width:350px">{{ $settlements['title']->order_description }}</th>
            <th style="min-width:300px">{{ $settlements['title']->contract_number }}</th>
            <th>{{ $settlements['title']->audit_number }}</th>
            <th>{{ $settlements['title']->cost }}</th>
            <th>{{ $settlements['title']->paid_cost }}</th>
            <th>{{ $settlements['title']->mis_cost }}</th>
            <th>{{ $settlements['title']->submit_cost }}</th>
            <th>{{ $settlements['title']->validation_cost }}</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($settlements['data'] as $data)
          <tr>
            <th class="id" scope="row">{{$data->id}}</th>
            <td class="order_number">{{$data->order_number}}</td>
            <td class="vendor_name">{{$data->vendor_name}}</td>
            <td class="material_name">{{$data->material_name}}</td>
            <td class="material_type">{{$data->material_type}}</td>
            <td class="project_number">{{$data->project_number}}</td>
            <td class="project_name">{{$data->project_name}}</td>
            <td class="project_manager">{{$data->project_manager}}</td>
            <td class="audit_progress">{{$data->audit_progress}}</td>
            <td class="audit_document_number">{{$data->audit_document_number}}</td>
            <td class="audit_company">{{$data->audit_company}}</td>
            <td class="order_description">{{$data->order_description}}</td>
            <td class="contract_number">{{$data->contract_number}}</td>
            <td class="audit_number">{{$data->audit_number}}</td>
            <td class="cost">{{$data->cost}}</td>
            <td class="paid_cost">{{$data->paid_cost}}</td>
            <td class="mis_cost">{{$data->mis_cost}}</td>
            <td class="submit_cost">{{$data->submit_cost}}</td>
            <td class="validation_cost">{{$data->validation_cost}}</td>

            <td class="action">
              @if(Auth::user()->hasAnyRole('高级管理员|站长'))
              <a class="update" title="编辑" onclick="tableeditanddelete.update(this)" href="javascript:;" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp;<a data-whatever="{{$data->id}}" data-toggle="modal" data-target="#myModal" title="删除" id="delete" href="javascript:;" role="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
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

{!! $settlements['data']->appends($querytoarray)->links() !!}
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

$(document).ready(function(){

  window.Echo.channel('all')
      .listen('ChangeOrder', function(e){

        $("#totalcontainer").prepend('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+e.name+e.mes+e.order_number+'的订单</div>');

      });

  $('#myModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var recipient = button.data('whatever'); // Extract info from data-* attributes
    $(this).find("#delete").attr('action','/settlements/'+recipient);
})
});

</script>
@stop
