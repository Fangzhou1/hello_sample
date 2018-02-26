@extends('layouts.default')
@section('title', '结算审计主页')

@section('content')

<div class="col-md-2">
@include('settlements.left')
</div>
<div class="col-md-4">
  <div class="jumbotron">
  <h1>下载模板</h1>
  <p><a class="btn btn-primary btn-lg btn-block" href="#" role="button">下载</a></p>
</div>
</div>
<div class="col-md-6">
  <div class="jumbotron">
<form class="inline">
<h1>导入EXCEL文件</h1>
  <div class="form-group">
    <input type="file" id="exampleInputFile" style="margin-left:33%">
  </div>
  <p><a class="btn btn-primary btn-lg btn-block" href="#" role="button">导入EXCEL</a></p>
</div>
</form>
</div>
@stop
