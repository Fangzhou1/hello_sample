@extends('layouts.default')

@section('title', '决算审计详情页')

@section('content')
<script type="text/javascript" src="/js/tableeditanddelete.js"></script>
<div class="col-md-2">
@include('layouts.left')
</div>
<div class="col-md-10">
<div class=row>
  <div class="col-md-4">
<a class="btn btn-primary" href="{{route('rreturns.smsmail')}}" role="button">返回</a>
  </div>

    <div class="col-md-8">
  <div class="btn-group" role="group">
    <a class="btn btn-default {{!isset($querytoarray['order'])||$querytoarray['order']==1?'active':""}}" href="{{$current_url}}?name={{$querytoarray['name']}}&type={{$querytoarray['type']}}&order=1" role="button">按审计进度排序</a>
    <a class="btn btn-default {{isset($querytoarray['order'])&&$querytoarray['order']==2?'active':""}}" href="{{$current_url}}?name={{$querytoarray['name']}}&type={{$querytoarray['type']}}&order=2" role="button">按工程项目排序</a>
  </div>&nbsp;&nbsp;

  @if($querytoarray['type']==1)
  <a class="btn btn-primary" href="{{route('rreturns.exportbytype')}}?project_manager={{$rreturns['data']->first()->project_manager}}" role="button">导出EXCEL表格</a>
  @else
  <a class="btn btn-primary" href="{{route('rreturns.exportbytype')}}?audit_company={{$rreturns['data']->first()->audit_company}}" role="button">导出EXCEL表格</a>
  @endif

  <span  class="pull-right" style="font-size: 18px;">总共查询到 {{$rreturns['data']->total()}} 行数据</span>
    </div>
</div>

<div class="table-responsive">
  <table class="table table-hover table-striped table-bordered">
        <thead>
          <tr>
            <th>id</th>
            <th>{{ $rreturns['title']->project_duration or ""}}</th>
            <th>{{ $rreturns['title']->project_number or ""}}</th>
            <th>{{ $rreturns['title']->project_name or ""}}</th>
            <th>{{ $rreturns['title']->project_manager or ""}}</th>
            <th>{{ $rreturns['title']->audit_progress or ""}}</th>
            <th>{{ $rreturns['title']->audit_document_number or ""}}</th>
            <th>{{ $rreturns['title']->audit_company or ""}}</th>
            <th>{{ $rreturns['title']->is_needsaudit or ""}}</th>
            <th>{{ $rreturns['title']->is_canaudit or ""}}</th>
            <th>{{ $rreturns['title']->audit_number or ""}}</th>
            <th>{{ $rreturns['title']->remarks or ""}}</th>

            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($rreturns['data'] as $data)
          <tr>
            <th class="id" scope="row">{{$data->id or ""}}</th>
            <td style="min-width:200px" class="project_duration">{{$data->project_duration or ""}}</td>
            <td style="min-width:320px" class="project_name">{{$data->project_name or ""}}</td>
            <td style="min-width:150px" class="project_number">{{$data->project_number or ""}}</td>
            <td style="min-width:150px" class="project_manager">{{$data->project_manager or ""}}</td>
            <td style="min-width:150px" class="audit_progress">{{$data->audit_progress or ""}}</td>
            <td class="audit_document_number">{{$data->audit_document_number or ""}}</td>
            <td class="audit_company">{{$data->audit_company or ""}}</td>
            <td class="is_needsaudit">{{$data->is_needsaudit or ""}}</td>
            <td class="is_canaudit">{{$data->is_canaudit or ""}}</td>
            <td class="audit_number">{{$data->audit_number or ""}}</td>
            <td style="min-width:320px" class="remarks">{{$data->remarks or ""}}</td>


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
{!! $rreturns['data']->appends($querytoarray)->links() !!}
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


$(document).ready(function(){
window.Echo.channel('all')
    .listen('ChangeOrder', function(e){

      $("#totalcontainer").prepend('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+e.name+e.mes+e.order_number+'的订单</div>');

    });


    $('#myModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var recipient = button.data('whatever'); // Extract info from data-* attributes
      $(this).find("#delete").attr('action','rreturns/'+recipient);
});

})
</script>
@stop
