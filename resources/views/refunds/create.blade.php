@extends('layouts.default')

@section('title','物资新增页')
@section('content')
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">添加审减物资退库条目</h3>
  </div>
  <div class="panel-body">
  <form method="POST" action="{{route('refunds.store')}}">
    {{ csrf_field() }}
  <div class="form-group">
    <label for="audit_report_name">审计报告名称</label>
    <input name="audit_report_name" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="professional_room">专业室</label>
    <select  name="professional_room" class="form-control">
    <option value="无线">无线</option>
    <option value="传输">传输</option>
    <option value="宽带">宽带</option>
    <option value="全业务">全业务</option></select>
  </div>
  <div class="form-group">
    <label for="project_manager">项目经理</label>
    <input name="project_manager" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="project_number">项目编号</label>
    <input name="project_number" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="publish_date">发文年</label>
    <input name="publish_date" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="audit_document_number">文号（文件字号）</label>
    <input name="audit_document_number" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="project_manager">项目经理</label>
    <input name="project_manager" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="audit_type">审计分类</label>
    <input name="audit_type" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="project_type">工程分类</label>
    <input name="project_type" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="audit_company">审计单位</label>
    <input name="audit_company" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="submit_cost">送审金额</label>
    <input name="submit_cost" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="validation_cost">审定金额</label>
    <input name="validation_cost" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="subtraction_cost">审减金额</label>
    <input name="subtraction_cost" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="subtraction_rate">审减率</label>
    <input name="subtraction_rate" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="mterials_audit">工程物资送审</label>
    <input name="mterials_audit" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="construction_should_refund">施工单位应退库</label>
    <input name="construction_should_refund" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="thing_refund">实物退库</label>
    <input name="thing_refund" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="cash_refund">现金退库</label>
    <input name="cash_refund" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="direct_yes">施工单位直接用于其它工程（有退库领用手续）</label>
    <input name="direct_yes" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="direct_no">施工单位直接用于其它工程（无退库领用手续）</label>
    <input name="direct_no" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="unrefund_cost">未退库金额</label>
    <input name="unrefund_cost" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="reason">未退库原因</label>
    <input name="reason" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="Remarks">备注</label>
    <input name="Remarks" type="text" class="form-control" placeholder="Text input">
  </div>

  <button type="submit" class="btn btn-primary">新增</button>
</form>
  </div>
</div>
</div>
@stop
