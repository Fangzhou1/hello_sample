@extends('layouts.default')

@section('title','物资编辑页')
@section('content')
<div class="col-md-1 page-header" style="margin-top: 0px;">
<a class="btn btn-primary" href="#" role="button">返回</a>
</div>
<div class="col-md-11 page-header" style="margin: 0px;">
<h1>物资详情编辑页</h1>
</div>

<form class="form-inline" method="post" action="{{route('refunddetails.update',$refunddetail->id)}}">
  {{ csrf_field() }}
  <input type="hidden" name="_method" value="PATCH">
<div class="col-md-12" style="margin-bottom:20px;">
  <div class="panel panel-success">
    <!-- Default panel contents -->
    <div class="panel-heading"><big>物资退库基本信息</big></div>

    <!-- Table -->
    <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>审计文号</th>
          <th>项目编号</th>
          <th>项目名称</th>
          <th>施工单位</th>
          <th>物料名称</th>
          <th style="width:5%">单价</th>
          <th>审减数量</th>
          <th>审减金额</th>
          <th>是否完成退库</th>



        </tr>

      </thead>
      <tbody>
        <tr>
          <td scope="row"><input name="audit_document_number" type="text" class="form-control" value='{{$refunddetail->audit_document_number}}' readonly = "readonly"></td>
          <td scope="row"><input name="project_number" type="text" class="form-control" value='{{$refunddetail->project_number}}' readonly = "readonly"></td>
          <td scope="row"><input name="project_name" type="text" class="form-control" value='{{$refunddetail->project_name}}'></td>
          <td scope="row"><input name="construction_enterprise" type="text" class="form-control" value='{{$refunddetail->construction_enterprise}}'></td>
          <td scope="row"><input name="material_name" type="text" class="form-control" value='{{$refunddetail->material_name}}'></td>
          <td scope="row"><input name="unit_price" id="unit_price" type="text" class="form-control" value='{{$refunddetail->unit_price}}'></td>
          <td scope="row"><input name="reduction_quantity" id="reduction_quantity" type="text" class="form-control" value='{{$refunddetail->reduction_quantity}}'></td>
          <td scope="row"><input name="subtraction_cost" id="subtraction_cost" type="text" class="form-control" value='{{$refunddetail->subtraction_cost}}' readonly = "readonly"></td>
          <td scope="row"><select name="iscomplete_refund" class="form-control"><option value="是" {{$refunddetail->iscomplete_refund=='是'?'selected':''}}>是</option><option value="否" {{$refunddetail->iscomplete_refund=='否'?'selected':''}}>否</option></select></td>


      </tbody>
    </table>
  </div>
</div>
</div>

<div class="col-md-12" style="margin-bottom:20px;">
  <div class="panel panel-success">
    <!-- Default panel contents -->
    <div class="panel-heading"><big>SCM及ERP申请退库情况</big></div>

    <!-- Table -->
    <table class="table">
      <thead>
        <tr>
          <th>SCM退库单号</th>
          <th>SCM申请退库数量</th>
          <th>ERP退库数量</th>
          <th>ERP退库单号</th>
          <th>ERP未退库原因</th>

        </tr>
      </thead>
      <tbody>
        <tr>
          <td scope="row"><input name="scm_refund_number" type="text" class="form-control" value='{{$refunddetail->scm_refund_number}}'></td>
          <td scope="row"><input name="refund_apply_amount" type="text" class="form-control" value='{{$refunddetail->refund_apply_amount}}'></td>
          <td scope="row"><input name="refund_amount" type="text" class="form-control" value='{{$refunddetail->refund_amount}}'></td>
          <td scope="row"><input name="erp_refund_number" type="text" class="form-control" value='{{$refunddetail->erp_refund_number}}'></td>
          <td scope="row"><input name="erp_unrefund_reason" type="text" class="form-control" value='{{$refunddetail->erp_unrefund_reason}}'></td>
        </tr>
      </tbody>
    </table>
    </div>
</div>

  <div class="col-md-12" style="margin-bottom:20px;">
    <div class="panel panel-success" style="margin:5px;">
      <!-- Default panel contents -->
      <div class="panel-heading" style="margin-bottom:5px;"><big>实际退库情况</big></div>
      <div class="panel panel-success col-md-6">
        <div class="panel-heading">实物退库情况</div>

      <!-- Table -->
      <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>SCM收货单号</th>
            <th>SCM收货数量(单价为：{{$unit_price}})</th>
            <th>退库金额</th>



          </tr>
        </thead>
        <tbody>
          <tr>
            <td scope="row"><input name="scm_receive_number" type="text" class="form-control" value='{{$refunddetail->scm_receive_number}}'></td>
            <td scope="row"><input name="scm_receive_amount" id="scm_receive_amount" type="text" class="form-control" value='{{$refunddetail->scm_receive_amount}}'></td>
            <td scope="row"><input name="refund_cost" id="refund_cost" type="text" class="form-control" value='{{$refunddetail->refund_cost}}' oninput="txtChange(this)" onpropertychange="txtChange(this)" readonly = "readonly"></td>

          </tr>
        </tbody>
      </table>
    </div>
  </div>

    <div class="panel panel-success col-md-3">
      <div class="panel-heading" >现金退库情况</div>

    <!-- Table -->
    <table class="table">
      <thead>
        <tr>

          <th>现金退库</th>



        </tr>
      </thead>
      <tbody>
        <tr>

          <td scope="row"><input name="cash_refund" id="cash_refund" type="text" class="form-control" value='{{$refunddetail->cash_refund}}'></td>

        </tr>
      </tbody>
    </table>
  </div>


  <div class="panel panel-success col-md-3">
    <div class="panel-heading" >未退库总金额</div>

  <!-- Table -->
  <table class="table">
    <thead>
      <tr>


        <th>未退库金额</th>


      </tr>
    </thead>
    <tbody>
      <tr>


        <td scope="row"><input name="unrefund_cost" id="unrefund_cost" type="text" class="form-control" value='{{$refunddetail->unrefund_cost}}'readonly = "readonly"></td>
      </tr>
    </tbody>
  </table>
</div>

  </div>
</div>



<div class="col-md-6" style="margin-bottom:20px;">
  <div class="panel panel-success">
    <!-- Default panel contents -->
    <div class="panel-heading"><big>未退库原因</big></div>

    <!-- Table -->
    <table class="table">


          <textarea name="unrefund_reason" class="form-control" rows="3" style="width:100%" placeholder="可以写一些东西...">{{$refunddetail->unrefund_reason}}</textarea>

    </table>
  </div>
</div>

<div class="col-md-6" style="margin-bottom:20px;">
  <div class="panel panel-success">
    <!-- Default panel contents -->
    <div class="panel-heading"><big>备注</big></div>

    <!-- Table -->
    <table class="table">


          <textarea name="remarks" class="form-control" rows="3" style="width:100%" placeholder="可以写一些东西...">{{$refunddetail->remarks}}</textarea>

    </table>
  </div>
</div>

<div class="col-md-offset-5 col-md-12">
<input class="btn btn-primary" type="submit" value="保存">
<a class="btn btn-default" href="javascript:history.back();" role="button">取消</a>
</div>
</form>
<script type="text/javascript">

function txtChange(el)
{
  document.getElementById('unrefund_cost').value=document.getElementById('subtraction_cost').value-document.getElementById('cash_refund').value-this.value;
}


$(document).ready(function(){

    $("#unit_price").blur(function(){
      $("#subtraction_cost").val($("#unit_price").val()*$("#reduction_quantity").val());
      // alert(typeof($("#refund_cost").val()));
      $("#unrefund_cost").val($("#subtraction_cost").val()*1-$("#cash_refund").val()*1-$("#refund_cost").val()*1);
    });


    $("#reduction_quantity").blur(function(){
      $("#subtraction_cost").val($("#unit_price").val()*$("#reduction_quantity").val());
      $("#unrefund_cost").val($("#subtraction_cost").val()*1-$("#cash_refund").val()*1-$("#refund_cost").val()*1);
    });

    $("#cash_refund").blur(function(){

      $("#unrefund_cost").val($("#subtraction_cost").val()*1-$("#cash_refund").val()*1-$("#refund_cost").val()*1);
    });

    $("#refund_cost").bind('input propertychange',function(){

      $("#unrefund_cost").val($("#subtraction_cost").val()*1-$("#cash_refund").val()*1-$("#refund_cost").val()*1);
    });

    $("#scm_receive_amount").blur(function(){

      $("#refund_cost").val({{$unit_price}}*$("#scm_receive_amount").val());
    });




});
</script>

@stop
