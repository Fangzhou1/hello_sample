@extends('layouts.default')

@section('title','添加决算审计条目')
@section('content')
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">添加决算审计条目</h3>
  </div>
  <div class="panel-body">
  <form method="POST" action="{{route('rreturns.store')}}">
    {{ csrf_field() }}
  <div class="form-group">
    <label for="project_duration">项目期限</label>
    <input name="project_duration" type="text" class="form-control" placeholder="Text input">
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
    <label for="audit_progress">决算审计进度</label>
    <input name="audit_progress" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="audit_document_number">决算审计文号</label>
    <input name="audit_document_number" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="audit_company">审计单位</label>
    <input name="audit_company" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="is_needsaudit">是否需要结算审计</label>
    <input name="is_needsaudit" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="is_canaudit">是否能够决算审计</label>
    <input name="is_canaudit" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="audit_number">送审编号</label>
    <input name="audit_number" type="text" class="form-control" placeholder="Text input">
  </div>
  <div class="form-group">
    <label for="remarks">备注</label>
    <input name="remarks" type="text" class="form-control" placeholder="Text input">
  </div>


  <button type="submit" class="btn btn-primary">新增决算条目</button>
</form>
  </div>
</div>
</div>
@stop
