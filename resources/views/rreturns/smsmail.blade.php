@extends('layouts.default')

@section('title','决算审计催办页')
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
<div class="col-md-3" style="min-height:150px">
  <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">项目经理：{{$key }}</h3>
  </div>
  <div class="panel-body">
    <p>所涉及的项目数：{{$data['project_num'] or 0}}个</p>
    <!-- <p>所涉及的订单数：{{$data['order_num'] or 0}}个</p> -->
    <hr>
    <p>未送审：{{$data['未送审'] or 0}}个<a class="pull-right btn btn-success" data-whatever1="{{json_encode($data)}}" data-whatever2="{{json_encode($data['notification_information'])}}" data-whatever3="mail" data-toggle="modal" data-target="#myModal" href="javascript:;" role="button">邮件通知</a></p>
    <p>审计中：{{$data['审计中'] or 0}}个<a class="pull-right btn btn-success" href="#" role="button">短信通知</a></p>
    <p>已退回：{{$data['被退回'] or 0}}个<a class="pull-right btn btn-success" data-whatever1="{{json_encode($data)}}" data-whatever2="{{json_encode($data['weixin_notification_information'])}}" data-whatever3="weixin" data-toggle="modal" data-target="#myModal" href="javascript:;" role="button">微信通知</a></p>
    <p>已出报告：{{$data['已出报告'] or 0}}个<a class="pull-right btn btn-success" href="{{route('rreturns.smsmaildetail')}}?name={{$key}}&type=1" role="button">查看详情</a></p>

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
    <!-- <p>所涉及的订单数：{{$data2['order_num'] or 0}}个</p> -->
    <hr>
    <p>未送审：{{$data2['未送审'] or 0}}个</p>
    <p>审计中：{{$data2['审计中'] or 0}}个</p>
    <p>已退回：{{$data2['被退回'] or 0}}个</p>
    <p>已出报告：{{$data2['已出报告'] or 0}}个<a class="pull-right btn btn-success" href="{{route('rreturns.smsmaildetail')}}?name={{$key}}&type=2" role="button">查看详情</a></p>
  </div>
</div>
</div>
@endforeach
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <form id="wrapiput" method="GET" action="" style="display:inline-block">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
        <div id="form_content" class="form-group">
          <label for="exampleInputEmail1"></label>

          <input type="hidden" name="emailinfo" value="" class="form-control" id="exampleInputEmail1">
        </div>
        <p id="ask"></p>
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

  window.Echo.channel('all')
      .listen('ChangeOrder', function(e){

        $("#totalcontainer").prepend('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+e.name+e.mes+e.order_number+'的订单</div>');

      });

      $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal

        var recipient2 = button.data('whatever2');// Extract info from data-* attributes
        var recipient1 = button.data('whatever1');
        var recipient3 = button.data('whatever3');
        //console.log(recipient2);
        if(recipient3=='mail'){
          $("#myModalLabel").text('发送邮件');
          $("#form_content label").text('请确认项目经理邮箱');
          $("#ask").text('是否确认发送邮件?');
          $road='sendemail';
        }
        else if(recipient3=='weixin'){
          $("#myModalLabel").text('发送微信');
          $("#form_content label").text('请确认所通知的项目经理');
          $("#ask").text('是否确认发送微信?');
          $road='/weixin/sendweixin/决算审计进度';
        }

        var form_content='<div id="form_content_wrap">';
        for(var key in recipient2)
        if(recipient3=='mail')
          form_content+=key+':<input type="email" name="'+key+'" class="form-control" value="'+recipient2[key]+'" placeholder="Email"></br>';
        else if(recipient3=='weixin')
          form_content+=key+'、<input type="hidden" name="'+key+'" class="form-control" value="'+recipient2[key]+'"></br>';
        form_content+='</div>';
        $("#form_content").append(form_content);

        $(this).find('input[name="emailinfo"]').attr('value',JSON.stringify(recipient1));
        $(this).find('#wrapiput').attr('action',$road);
      });



      $('#myModal').on('hide.bs.modal', function (event) {
        $('#form_content_wrap').remove();
      });
});
</script>
@stop
