@extends('layouts.default')
<script type="text/javascript" src="/js/statistics.js"></script>
@section('title','登录及操作')
@section('content')
<div class="col-md-2">
@include('layouts.left')
</div>
<div class="col-md-10">
  <div class="col-md-6">
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
          <td>1</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    </div>
    <div class="col-md-6">
      <div class="col-md-6" id="main1" style="height:400px;"></div>
      </div>
      <div class="col-md-6">
        </div>
        <div class="col-md-6">
          </div>
</div>
<script type="text/javascript">

$(document).ready(function(){
window.Echo.channel('all')
    .listen('ChangeOrder', function(e){

      $("#totalcontainer").prepend('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+e.name+e.mes+e.order_number+'的订单</div>');

    });
  });
       // 基于准备好的dom，初始化echarts实例
       var myChart1 = echarts.init(document.getElementById('main1'));
       var myChart2 = echarts.init(document.getElementById('main2'));


       // 指定图表的配置项和数据
       var option1 = {
           title: {
               text: '用户登录统计'
           },
           tooltip: {},
           legend: {
               data:['日登录总数']
           },
           xAxis: {

               data: ["未送审","被退回","审计中","已出报告"],

           },
           yAxis: {

           },
           series: [
             {
               name: '订单数',
               type: 'bar',
               barWidth: '50%',
               data: [{{$newdata1['未送审'] or 0}}, {{$newdata1['被退回'] or 0}}, {{$newdata1['审计中'] or 0}}, {{$newdata1['已出报告'] or 0}}]
           }]
       };



    var  option2 = {
    title: {
        text: '结算审计进度'
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

        data:['完成审计订单数','完成审计项目数']
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
        data: ["{{$newdata2['xdata'][0] or 0}}","{{$newdata2['xdata'][1] or 0}}","{{$newdata2['xdata'][2] or 0}}","{{$newdata2['xdata'][3] or 0}}","{{$newdata2['xdata'][4] or 0}}","{{$newdata2['xdata'][5] or 0}}","{{$newdata2['xdata'][6] or 0}}"]

    },
    yAxis: {
        type: 'value'
    },
    series: [
        {
            name:'完成审计订单数',
            type:'line',
            data:[{{$newdata2['ydata_ordernum'] or ""}}]
          },
        {
            name:'完成审计项目数',
            type:'line',
            data: [{{$newdata2['ydata_projectnum'] or ""}}]
            //data: ['1','1','1','1','1','2','2']
        },

    ]
};

       // 使用刚指定的配置项和数据显示图表。
       myChart1.setOption(option1);
       myChart2.setOption(option2);
       myChart3.setOption(option3);
   </script>
@stop
