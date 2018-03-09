@extends('layouts.default')
@section('title', '结算审计主页')

@section('content')

<div class="col-md-2">
@include('settlements.left')
</div>
<div class="col-md-4">
  <div class="jumbotron">
  <h1>下载模板</h1><br /> <br />
  <p><a class="btn btn-success btn-lg btn-block" href="#" role="button">下载</a></p>
</div>
</div>
<div class="col-md-6">
  <div class="jumbotron">
<form method="post" class="inline" action="{{route('import')}}" enctype="multipart/form-data">
{{ csrf_field() }}
<h1>导入EXCEL文件</h1>
  <div class="form-group">
    <input type="file" name='excel' id="exampleInputFile" style="margin-left:33%">
  </div>
  <p><input class="btn btn-success btn-lg btn-block" type="submit" value="导入EXCEL"></p>
</div>
</form>
</div>
@stop
