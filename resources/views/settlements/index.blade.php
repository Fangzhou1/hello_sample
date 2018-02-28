@extends('layouts.default')
@section('title', '结算审计主页')

@section('content')

<div class="col-md-2">
@include('settlements.left')
</div>
<div class="col-md-10">

<div class="table-responsive">
  <table class="table table-hover table-striped table-responsive">
        <thead>
          <tr>
            <th>id</th>
            <th>{{ $settlements['title']->order_number }}</th>
            <th>{{ $settlements['title']->vendor_name }}</th>
            <th>{{ $settlements['title']->material_name }}</th>
            <th>{{ $settlements['title']->material_type }}</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($settlements['data'] as $data)
          <tr>
            <th scope="row">{{$data->id}}</th>
            <td class="order_number">{{$data->order_number}}</td>
            <td class="vendor_name">{{$data->vendor_name}}</td>
            <td class="material_name">{{$data->material_name}}</td>
            <td class="material_type">{{$data->material_type}}</td>
            <td class="action"><a id="update" title="编辑" href="javascript:;" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true">|<a title="删除" href="#" role="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>
          </tr>
            @endforeach

        </tbody>
      </table>
</div>
      {!! $settlements['data']->links() !!}
</div>
<script type="text/javascript">
$(document).ready(function(){
  $("#update").click(function(){

    var tem={"order_number":$(this).parents('tr').find(".order_number").text(),
    "vendor_name":$(this).parents('tr').find(".vendor_name").text(),
    "material_name":$(this).parents('tr').find(".material_name").text(),
    "material_type":$(this).parents('tr').find(".material_type").text()}

    $(this).parents('tr').find(".order_number").html('<form method="POST" action="{{ route('users.store') }}"><input type="text" name=class="form-control input-sm" value='+tem.order_number+'>');
    $(this).parents('tr').find(".vendor_name").html('<input type="text" name=class="form-control input-sm" value='+tem.vendor_name+'>');
    $(this).parents('tr').find(".material_name").html('<input type="text" name=class="form-control input-sm" value='+tem.material_name+'>');
    $(this).parents('tr').find(".material_type").html('<input type="text" name=class="form-control input-sm" value='+tem.material_type+'>');
    $(this).parents('tr').find(".action").html('<input class="btn btn-default btn-xs" type="submit" value="提交">|<a class="btn btn-default btn-xs" href="{{route('rowupdatecancel')}}" role="button">取消</a></form>');
  });
});
</script>
@stop
