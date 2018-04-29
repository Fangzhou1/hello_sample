@extends('layouts.default')
<script type="text/javascript" src="/js/statistics.js"></script>
@section('title','登录及操作')
@section('content')
<div class="col-md-2">
@include('layouts.left')
</div>
<div class="col-md-10">
  <div class="row">
  <div class="col-md-3">
    <form id="select1">

    请选择年月：<select name='yearandmonth' class="form-control">
      @foreach ($datas0 as $data0)
    <option  {{$click_yearandmonth==$data0?'selected':''}} value='{{$data0}}'>{{$data0}}</option>
      @endforeach
    </select>

    </form>
  </div>

  <div class="col-md-9">

  </div>
  </div>

  <div class="row">
  <div class="col-md-6">
    <div class="table-responsive" style="height:400px;">
    <table class="table table-striped table-condensed">
      <thead>
        <tr>
          <th>名字</th>
          <th>登录次数</th>
          <th>详情</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($datas1 as $data1)
        <tr>
          <td>{{$data1->name}}</td>
          <td>{{$data1->loginnum}}</td>
          <td><button type="button" class="btn btn-default" aria-label="Left Align" data-toggle="modal" data-target="#exampleModal" data-whatever1="{{$data1->name}}">
  <span title='详情' class="glyphicon glyphicon-align-left" aria-hidden="true"></span>
</button></td>
        </tr>
        @endforeach
        @foreach ($datas1_supplements as $datas1_supplement)
        <tr>
          <td>{{$datas1_supplement}}</td>
          <td>0</td>
          <td>/</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    </div>
    </div>
    <div class="col-md-6">
      <div class="col-md-12" id="main1" style="height:400px;"></div>
      </div>
      <div class="col-md-6">
        </div>
        <div class="col-md-6">
          </div>
        </div>
  </div>

<!-- 模态框 -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">New message</h4>
              </div>
              <div class="modal-body">
                <form>
                  <div class="form-group">
                    <label for="recipient-name" class="control-label">Recipient:</label>
                    <input type="text" class="form-control" id="recipient-name">
                  </div>
                  <div class="form-group">
                    <label for="message-text" class="control-label">Message:</label>
                    <textarea class="form-control" id="message-text"></textarea>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Send message</button>
              </div>
            </div>
          </div>
        </div>




<script type="text/javascript">

$(document).ready(function(){
window.Echo.channel('all')
    .listen('ChangeOrder', function(e){

      $("#totalcontainer").prepend('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+e.name+e.mes+e.order_number+'的订单</div>');

    });
  });



  $('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal
  var recipient = button.data('whatever1'); // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this);
  modal.find('.modal-title').text(recipient+'的登录详情');
  modal.find('.modal-body input').val(recipient);
})



$("#select1 select").change(function(){
  //alert('aa');

  window.location.href="{{route('baseinformation.loginaction')}}?"+$("form").serialize();

})



       // 基于准备好的dom，初始化echarts实例
       var myChart1 = echarts.init(document.getElementById('main1'));
       //var myChart2 = echarts.init(document.getElementById('main2'));


       // 指定图表的配置项和数据
       var  option1 = {
       title: {
           text: '用户登录统计({{$datas2['title']}})'
       },
       tooltip: {
           trigger: 'axis',
           axisPointer: {
           type: 'cross',
           label: {
               backgroundColor: '#6a7985'
           }
       }
       },
       legend: {

           data:['用户登录总数']
       },
       grid: {
           left: '3%',
           right: '4%',
           bottom: '3%',
           containLabel: true
       },
       toolbox: {
           feature: {
               saveAsImage: {}
           }
       },
       xAxis: {
           type: 'category',
           boundaryGap: false,
           //data: [1,2,3,4,5,6,7]
           data: {!!$datas2['x']!!}

       },
       yAxis: {
           type: 'value'
       },
       series: [
           {
               name:'日登录总数',
               type:'line',
               data:{{$datas2['y']}}
             },
       ]
   };



//     var  option2 = {
//     title: {
//         text: '结算审计进度'
//     },
//     tooltip: {
//         trigger: 'axis',
//         axisPointer: {
//         type: 'cross',
//         label: {
//             backgroundColor: '#6a7985'
//         }
//     }
//     },
//     legend: {
//
//         data:['完成审计订单数','完成审计项目数']
//     },
//     grid: {
//         left: '3%',
//         right: '4%',
//         bottom: '3%',
//         containLabel: true
//     },
//     toolbox: {
//         feature: {
//             saveAsImage: {}
//         }
//     },
//     xAxis: {
//         type: 'category',
//         boundaryGap: false,
//         //data: [1,2,3,4,5,6,7]
//         data: ["{{$newdata2['xdata'][0] or 0}}","{{$newdata2['xdata'][1] or 0}}","{{$newdata2['xdata'][2] or 0}}","{{$newdata2['xdata'][3] or 0}}","{{$newdata2['xdata'][4] or 0}}","{{$newdata2['xdata'][5] or 0}}","{{$newdata2['xdata'][6] or 0}}"]
//
//     },
//     yAxis: {
//         type: 'value'
//     },
//     series: [
//         {
//             name:'完成审计订单数',
//             type:'line',
//             data:[{{$newdata2['ydata_ordernum'] or ""}}]
//           },
//         {
//             name:'完成审计项目数',
//             type:'line',
//             data: [{{$newdata2['ydata_projectnum'] or ""}}]
//             //data: ['1','1','1','1','1','2','2']
//         },
//
//     ]
// };

       // 使用刚指定的配置项和数据显示图表。
       myChart1.setOption(option1);
//       myChart2.setOption(option2);

   </script>
@stop
