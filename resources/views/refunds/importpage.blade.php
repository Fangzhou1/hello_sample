@extends('layouts.default')
@section('title', '物资退库批量导入')

@section('content')

<div class="col-md-2">
@include('layouts.left')
</div>
<div class="col-md-10">
  <div class="jumbotron">
  <h1>下载模板</h1><br /> <br />
  <p><a class="btn btn-success btn-lg btn-block" href="{{route('download.jesmb')}}" role="button">下载</a></p>
</div>

<div class="col-md-6">
  <div class="jumbotron">
<form method="post" class="inline" action="{{route('refunds.importrefunds')}}" enctype="multipart/form-data">
{{ csrf_field() }}
<h1>导入物资退库表的EXCEL文件</h1>
  <div class="form-group">
    <input type="file" name='excel_r' id="exampleInputFile1" style="margin-left:33%">
  </div>
  <p><input class="btn btn-success btn-lg btn-block" type="submit" value="导入EXCEL"></p>
</div>
</form>
</div>

<div class="col-md-6">
  <div class="jumbotron">
<form method="post" class="inline" action="{{route('refunds.importrefunddetails')}}" enctype="multipart/form-data">
{{ csrf_field() }}
<h1>导入物资退库详情表的EXCEL文件</h1>
  <div class="form-group">
    <input type="file" name='excel_d' id="exampleInputFile2" style="margin-left:33%">
  </div>
  <p><input class="btn btn-success btn-lg btn-block" type="submit" value="导入EXCEL"></p>
</div>
</form>
</div>

</div>
@stop
