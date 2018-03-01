@extends('layouts.default')
@section('title', '结算审计主页')

@section('content')

<div class="col-md-2">
@include('settlements.left')
</div>
<div class="col-md-10">

<div class="table-responsive">
  <table class="table table-hover table-striped">
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
            <th class="id" scope="row">{{$data->id}}</th>
            <td class="order_number">{{$data->order_number}}</td>
            <td class="vendor_name">{{$data->vendor_name}}</td>
            <td class="material_name">{{$data->material_name}}</td>
            <td class="material_type">{{$data->material_type}}</td>
            <td class="action"><a id="update" title="编辑" href="javascript:;" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true">&nbsp<a data-whatever="{{$data->id}}" data-toggle="modal" data-target="#myModal" title="删除" id="delete" href="javascript:;" role="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>
          </tr>
            @endforeach

        </tbody>
      </table>

</div>
{!! $settlements['data']->links() !!}
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">警告</h4>
      </div>
      <div class="modal-body">
        你确定删除吗？
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        
          {{ method_field('DELETE') }}
          {{ csrf_field() }}
        <input class="btn btn-primary" type="submit" value="确定">

      </div>
    </div>
  </div>
</div>




<script type="text/javascript">


$(document).ready(function(){
  $("#update").click(function(){

    var tem={"order_number":$(this).parents('tr').find(".order_number").text(),
    "vendor_name":$(this).parents('tr').find(".vendor_name").text(),
    "material_name":$(this).parents('tr').find(".material_name").text(),
    "material_type":$(this).parents('tr').find(".material_type").text(),
    "id":$(this).parents('tr').find(".id").text()
  }
    $(this).parents('.table').wrapAll('<form method="POST" action="/settlements/rowupdate/'+tem.id+'">');
    $(this).parents('tr').find(".order_number").html('<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"><input type="text" name="order_number" class="form-control input-sm" value='+tem.order_number+'>');
    $(this).parents('tr').find(".vendor_name").html('<input type="text" name="vendor_name" class="form-control input-sm" value='+tem.vendor_name+'>');
    $(this).parents('tr').find(".material_name").html('<input type="text" name="material_name" class="form-control input-sm" value='+tem.material_name+'>');
    $(this).parents('tr').find(".material_type").html('<input type="text" name="material_type" class="form-control input-sm" value='+tem.material_type+'>');
    $(this).parents('tr').find(".action").html('<input class="btn btn-default btn-xs" type="submit" value="提交">|<a class="btn btn-default btn-xs" href="{{route('rowupdatecancel')}}" role="button">取消</a>');

  });

  $('#myModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var recipient = button.data('whatever'); // Extract info from data-* attributes
    $(this).find(".modal-footer").wrapAll('<form method="POST" action="/settlements/'+recipient+'" style="display:inline-block">');

  });


});
</script>
@stop
