@extends('layouts.default')

@section('title','催办页')
@section('content')
<div class="col-md-2">
@include('layouts.left')
</div>
<div class="col-md-10" >
<div class="col-md-12 page-header" style="margin-top: 0px;">
  <h1><small><b>按项目经理统计</b></small></h1>
  @if ($datas === [])
  <div style="text-align: center;">无数据</div>
  @endif
</div>

@foreach ($datas as $key=>$data)
<div class="col-md-4">
  <div style="min_height=211.4px" class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">项目经理：{{$data->project_manager or ""}}</h3>
  </div>
  <div class="panel-body">
    <!-- <p>所涉及的项目数：{{$data->project_num or 0}}个</p><a class="pull-right btn btn-success" href="{{route('settlements.sendemail',[http_build_query($data),$key])}}" role="button">邮件通知</a> -->
    <p><b>所涉及的项目数：</b>{{$data->project_num or 0}}个</p>
    <hr>
    <p><b>应退库总金额：</b></p><p>{{$data->construction_should_refund_total or 0}}元<a class="pull-right btn btn-success" data-whatever1="{{json_encode($data)}}" data-whatever2="{{json_encode($data->notification_information)}}"  data-toggle="modal" data-target="#myModal" href="javascript:;" role="button">邮件通知</a></p>
    <p><b>实物退库总金额：</b></p><p>{{$data->thing_refund_total or 0}}元<a class="pull-right btn btn-success" href="#" role="button">短信通知</a></p>
    <p><b>现金退库总金额：</b></p><p>{{$data->cash_refund_total or 0}}元<a class="pull-right btn btn-success" href="#" role="button">微信通知</a></p>
    <p><b>直接用于其他工程（有手续）：</b></p><p>{{$data->direct_yes_total or 0}}元</p>
    <p><b>直接用于其他工程（无手续）：</b></p><p>{{$data->direct_no_total or 0}}元</p>
    <p><b>未退库金额：</b></p><p>{{$data->unrefund_cost_total or 0}}元<a class="pull-right btn btn-success" href="{{route('refunds.smsmaildetail')}}?name={{$data->project_manager}}&type=1" role="button">查看详情</a></p>
  </div>
</div>
</div>
@endforeach

<div class="col-md-12 page-header" style="margin-top: 0px;">
  <h1><small><b>按专业室统计</b></small></h1>
  @if ($datas2 === [])
  <div style="text-align: center;">无数据</div>
  @endif
</div>

@foreach ($datas2 as $key=>$data)
<div class="col-md-4">
  <div style="min_height=211.4px" class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">专业室：{{$data->professional_room or ""}}</h3>
  </div>
  <div class="panel-body">
    <!-- <p>所涉及的项目数：{{$data->project_num or 0}}个</p><a class="pull-right btn btn-success" href="{{route('settlements.sendemail',[http_build_query($data),$key])}}" role="button">邮件通知</a> -->
    <p><b>所涉及的项目数：</b>{{$data->project_num or 0}}个</p>
    <hr>
    <p><b>应退库总金额：</b></p><p>{{$data->construction_should_refund_total or 0}}元<a class="pull-right btn btn-success" data-whatever="{{http_build_query($data)}}"  data-toggle="modal" data-target="#myModal" href="javascript:;" role="button">邮件通知</a></p>
    <p><b>实物退库总金额：</b></p><p>{{$data->thing_refund_total or 0}}元<a class="pull-right btn btn-success" href="#" role="button">短信通知</a></p>
    <p><b>现金退库总金额：</b></p><p>{{$data->cash_refund_total or 0}}元<a class="pull-right btn btn-success" data-whatever="{{http_build_query($data)}}&manager={{$key}}"  data-toggle="modal" data-target="#myModal" href="javascript:;" role="button">微信通知</a></p>
    <p><b>直接用于其他工程（有手续）：</b></p><p>{{$data->direct_yes_total or 0}}元</p>
    <p><b>直接用于其他工程（无手续）：</b></p><p>{{$data->direct_no_total or 0}}元</p>
    <p><b>未退库金额：</b></p><p>{{$data->unrefund_cost_total or 0}}元<a class="pull-right btn btn-success" href="{{route('refunds.smsmaildetail')}}?name={{$data->professional_room}}&type=2" role="button">查看详情</a></p>
  </div>
</div>
</div>
@endforeach

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <form id="wrapiput" method="GET" action="" style="display:inline-block">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">发送邮件</h4>
      </div>
      <div class="modal-body">
        <div id="form_content" class="form-group">
          <label for="exampleInputEmail1">请确认项目经理邮箱</label>

          <input type="hidden" name="emailinfo" value="" class="form-control" id="exampleInputEmail1">
        </div>
        <p>你确定发送邮件吗？</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:">取消</button>
        <input class="btn btn-primary pull-right" type="submit" value="确定">
      </div>
    </div>
  </form>
  </div>
</div>



<script type="text/javascript">
$(document).ready(function(){

  window.Echo.channel('all')
      .listen('ChangeOrder', function(e){

        $("#totalcontainer").prepend('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+e.name+e.mes+e.order_number+'的订单</div>');

      });



  $('#myModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal

    var recipient2 = button.data('whatever2');// Extract info from data-* attributes
    var recipient1 = button.data('whatever1');
    var form_content='<div id="form_content_wrap">';
    for(var key in recipient2)
      form_content+=key+':<input type="email" name="'+key+'" class="form-control" value="'+recipient2[key]+'" placeholder="Email"></br>';
    form_content+='</div>';
    $("#form_content").append(form_content);

    $(this).find('input[name="emailinfo"]').attr('value',JSON.stringify(recipient1));
    $(this).find('#wrapiput').attr('action','/refunds/sendemail');
});

  $('#myModal').on('hide.bs.modal', function (event) {
    $('#form_content_wrap').remove();
  });


});
</script>
@stop
