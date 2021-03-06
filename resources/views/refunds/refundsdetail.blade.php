@extends('layouts.default')

@section('title','物资详情')
@section('content')
<div class="col-md-12 page-header" style="margin-top: 0px;">
<a class="btn btn-primary" href="{{route('refunds.index')}}" role="button">返回</a>&nbsp;&nbsp;<a class="btn btn-primary" href="{{route('download.refunddetailmb')}}" role="button">导出物资详情模板</a><h1><small><b>项目编号：{{$refundsdetails['data']->refund->project_number or ''}}，审计报告为：《{{$refundsdetails['data']->refund->audit_report_name}}》（文号：{{$refundsdetails['data']->refund->audit_document_number}}）<p>物资详情如下：</p></b></small></h1>
<h2 style="width:55%;margin:5px auto">总计:施工单位应退库：{{$refunddetails_total->construction_should_refund_total}}元，实物退库：{{$refunddetails_total->thing_refund_total}}元，现金退库金额：{{$refunddetails_total->cash_refund_total}}元，未退库金额：{{$refunddetails_total->unrefund_cost_total}}元</h2>
</div>


  @hasanyrole('项目经理|高级管理员|站长')
<a class="btn btn-success" href="{{route('refunddetails.create')}}?project_number={{$refundsdetails['data']->refund->project_number or ''}}&audit_document_number={{$refundsdetails['data']->refund->audit_document_number or ''}}&refundid={{$refundsdetails['data']->refund->id}}" role="button">添加新的物资&nbsp;<b>+</b></a>
&nbsp;|&nbsp;
<form method="post" action="{{route('refunddetails.importrefunddetailsbymanager')}}" enctype="multipart/form-data" style="display:inline-block">
  {{ csrf_field() }}
  <input class="btn btn-success" type="submit" value="批量添加你的物资详情" style="display:inline-block">
  <input type="file" name='excel_d_bym' id="exampleInputFile2" style="display:inline-block">
  <input type="hidden" name='kkk' value="{{$refundsdetails['data']->refund->kkk}}">
</form>

@endhasanyrole
<span  class="pull-right" style="font-size: 18px;">总共查询到{{$refundsdetails['data']->total()}}行数据</span>
</div>
<div class="col-md-12">
<div class="table-responsive">
  <table class="table table-hover table-striped table-bordered">
        <thead>
          <tr>
            <th>id</th>
            <th style="min-width:200px">{{ $refundsdetails['title']->audit_document_number or ""}}</th>
            <th>{{ $refundsdetails['title']->project_number or ""}}</th>
            <th style="min-width:250px">{{ $refundsdetails['title']->project_name or ""}}</th>
            <th style="min-width:150px">{{ $refundsdetails['title']->construction_enterprise or ""}}</th>
            <th style="min-width:300px">{{ $refundsdetails['title']->material_name or ""}}</th>
            <th style="min-width:150px">{{ $refundsdetails['title']->unit_price or ""}}</th>
            <th>{{ $refundsdetails['title']->reduction_quantity or ""}}</th>
            <th>{{ $refundsdetails['title']->subtraction_cost or ""}}</th>
            <th>{{ $refundsdetails['title']->scm_refund_number or ""}}</th>
            <th>{{ $refundsdetails['title']->refund_apply_amount or ""}}</th>
            <th>{{ $refundsdetails['title']->refund_amount or ""}}</th>
            <th>{{ $refundsdetails['title']->erp_refund_number or ""}}</th>
            <th>{{ $refundsdetails['title']->erp_unrefund_reason or ""}}</th>
            <th>{{ $refundsdetails['title']->scm_receive_number or ""}}</th>
            <th>{{ $refundsdetails['title']->scm_receive_amount or ""}}</th>
            <th>{{ $refundsdetails['title']->refund_cost or ""}}</th>
            <th>{{ $refundsdetails['title']->cash_refund or ""}}</th>
            <th>{{ $refundsdetails['title']->unrefund_cost or ""}}</th>
            <th>{{ $refundsdetails['title']->iscomplete_refund or ""}}</th>
            <th>{{ $refundsdetails['title']->unrefund_reason or ""}}</th>
            <th style="min-width:300px">{{ $refundsdetails['title']->remarks or ""}}</th>

            <th>操作</th>

          </tr>
        </thead>
        <tbody>
          @foreach ($refundsdetails['data'] as $data)
          <tr>
            <th class="id" scope="row">{{$data->id or ""}}</th>
            <td class="audit_report_name">{{$data->audit_document_number or ""}}</td>
            <td class="professional_room">{{$data->project_number or ""}}</td>
            <td class="project_manager">{{$data->project_name or ""}}</td>
            <td class="project_number">{{$data->construction_enterprise or ""}}</td>
            <td class="publish_date">{{$data->material_name or ""}}</td>
            <td class="audit_document_number">{{$data->unit_price or ""}}</td>
            <td class="audit_type">{{$data->reduction_quantity or ""}}</td>
            <td class="project_type">{{$data->subtraction_cost or ""}}</td>
            <td class="audit_company">{{$data->scm_refund_number or ""}}</td>
            <td class="submit_cost">{{$data->refund_apply_amount or ""}}</td>
            <td class="validation_cost">{{$data->refund_amount or ""}}</td>
            <td class="subtraction_cost">{{$data->erp_refund_number or ""}}</td>
            <td class="subtraction_rate">{{$data->erp_unrefund_reason or ""}}</td>
            <td class="mterials_audit">{{$data->scm_receive_number or ""}}</td>
            <td class="construction_should_refund">{{$data->scm_receive_amount or ""}}</td>
            <td class="thing_refund">{{$data->refund_cost or ""}}</td>
            <td class="cash_refund">{{$data->cash_refund or ""}}</td>
            <td class="direct_yes">{{$data->unrefund_cost or ""}}</td>
            <td class="direct_no">{{$data->iscomplete_refund or ""}}</td>
            <td class="unrefund_cost">{{$data->unrefund_reason or ""}}</td>
            <td class="reason">{{$data->remarks or ""}}</td>



            <td class="action">
<a class="update" title="编辑"  href="{{route('refunddetails.edit',$data->id)}}?refundid={{$refundsdetails['data']->refund->id}}" role="button"><span class="glyphicon glyphicon-pencil"></span></a>
&nbsp;<a data-whatever="{{$data->id}}" data-toggle="modal" data-target="#myModal" title="删除" id="delete" href="javascript:;" role="button"><span class="glyphicon glyphicon-remove"></span></a>
            </td>


          </tr>

            @endforeach

        </tbody>
      </table>
</div>
</div>
{!! $refundsdetails['data']->links() !!}
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
$(document).ready(function(){

window.Echo.channel('all')
    .listen('ChangeOrder', function(e){

      $("#totalcontainer").prepend('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+e.name+e.mes+e.order_number+'</div>');

    });


$('#myModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal
  var recipient = button.data('whatever'); // Extract info from data-* attributes
  $(this).find("#delete").attr('action','/audit_navigation/refunddetails/'+recipient);

});
});
</script>
@stop
