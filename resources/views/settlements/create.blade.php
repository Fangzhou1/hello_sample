@extends('layouts.default')

@section('title','帮助')
@section('content')
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">添加结算审计订单</h3>
  </div>
  <div class="panel-body">
  <form method="POST" action="{{route('settlements.store')}}">
    {{ csrf_field() }}
  <div class="form-group">
    <label for="order_number">订单编号</label>
    <input name="order_number" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="vendor_name">供应商名称</label>
    <input name="vendor_name" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">材料名称</label>
    <input name="material_name" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">材料类型</label>
    <input name="material_type" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="project_number">项目编号</label>
    <input name="project_number" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="project_name">项目名称</label>
    <input name="project_name" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="project_manager">项目经理</label>
    <input name="project_manager" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="audit_progress">审计进度</label>
    <select  name="audit_progress" class="form-control">
    <option value="未送审">未送审</option>
    <option value="审计中">审计中</option>
    <option value="被退回">被退回</option>
    <option value="已出报告">已出报告</option></select>
  </div>
  <div class="form-group">
    <label for="audit_document_number">审计文号</label>
    <input name="audit_document_number" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="audit_company">审计单位</label>
    <input name="audit_company" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="order_description">订单说明</label>
    <input name="order_description" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="contract_number">合同编号</label>
    <input name="contract_number" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="audit_number">平台送审编号</label>
    <input name="audit_number" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="cost">行金额</label>
    <input name="cost" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="paid_cost">已付款金额</label>
    <input name="paid_cost" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="mis_cost">MIS金额</label>
    <input name="mis_cost" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="submit_cost">送审金额</label>
    <input name="submit_cost" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="validation_cost">审定金额</label>
    <input name="validation_cost" type="text" class="form-control" placeholder="Text input">
  </div>

  <button type="submit" class="btn btn-primary">新增审计订单</button>
</form>
  </div>
</div>
</div>
@stop
