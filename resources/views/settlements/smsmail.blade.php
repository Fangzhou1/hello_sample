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
<div class="col-md-3">
  <div style="min_height=211.4px" class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">项目经理：{{$key }}</h3>
  </div>
  <div class="panel-body">
    <!-- <p>所涉及的项目数：{{$data['project_num'] or 0}}个</p><a class="pull-right btn btn-success" href="{{route('settlements.sendemail',[http_build_query($data),$key])}}" role="button">邮件通知</a> -->
    <p>所涉及的订单数：{{$data['order_num'] or 0}}个</p>
    <hr>
    <p>未送审：{{$data['未送审'] or 0}}个<a class="pull-right btn btn-success" data-whatever="{{http_build_query($data)}}"  data-toggle="modal" data-target="#myModal" href="javascript:;" role="button">邮件通知</a></p>
    <p>审计中：{{$data['审计中'] or 0}}个<a class="pull-right btn btn-success" href="#" role="button">短信通知</a></p>
    <p>已退回：{{$data['被退回'] or 0}}个</p>
    <p>已出报告：{{$data['已出报告'] or 0}}个<a class="pull-right btn btn-success" href="{{route('settlements.smsmaildetail')}}?name={{$key}}&type=1" role="button">查看详情</a></p>

  </div>
</div>
</div>
@endforeach


<div class="col-md-12 page-header" style="margin-top: 0px;">
  <h1><small><b>按审计单位统计</b></small></h1>
</div>
@if ($datas === [])
<div style="text-align: center;">无数据</div>
@endif
@foreach ($datas2 as $key=>$data2)
<div class="col-md-3">
  <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">审计单位：{{$key}}</h3>
  </div>
  <div class="panel-body">
    <p>所涉及的项目数：{{$data2['project_num'] or 0}}个</p>
    <p>所涉及的订单数：{{$data2['order_num'] or 0}}个</p>
    <hr>
    <p>未送审：{{$data2['未送审'] or 0}}个</p>
    <p>审计中：{{$data2['审计中'] or 0}}个</p>
    <p>已退回：{{$data2['被退回'] or 0}}个</p>
    <p>已出报告：{{$data2['已出报告'] or 0}}个<a class="pull-right btn btn-success" href="{{route('settlements.smsmaildetail')}}?name={{$key}}&type=2" role="button">查看详情</a></p>
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
        <div class="form-group">
          <label for="exampleInputEmail1">请填写项目经理邮箱</label>
          <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
          <input type="hidden" name="emailinfo" value="" class="form-control" id="exampleInputEmail1">
        </div>
        <p>你确定发送邮件吗？</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <input class="btn btn-primary pull-right" type="submit" value="确定">
      </div>
    </div>
  </form>
  </div>
</div>



<script type="text/javascript">
$(document).ready(function(){
  $('#myModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal

    var recipient = button.data('whatever')// Extract info from data-* attributes
    //alert(recipient);
    $(this).find('input[name="emailinfo"]').attr('value',recipient);
    $(this).find('#wrapiput').attr('action','/settlements/sendemail');
});
});
</script>
@stop
