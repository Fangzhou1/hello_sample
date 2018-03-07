@extends('layouts.default')
<script type="text/javascript" src="/js/statistics.js"></script>
@section('title','关于')
@section('content')
<div class="col-md-2">
@include('settlements.left')
</div>
<div class="col-md-10">

      <div class="col-md-6" id="main1" style="height:400px;"></div>
      <div class="col-md-6" id="main3" style="height:400px;"></div>
      <div class="col-md-12" id="main2" style="height:400px;"></div>
</div>
<script type="text/javascript">
       // 基于准备好的dom，初始化echarts实例
       var myChart1 = echarts.init(document.getElementById('main1'));
       var myChart2 = echarts.init(document.getElementById('main2'));
       var myChart3 = echarts.init(document.getElementById('main3'));

       // 指定图表的配置项和数据
       var option1 = {
           title: {
               text: '结算审计订单情况统计'
           },
           tooltip: {},
           legend: {
               data:['订单数']
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
               data: [{{$newdata1['未送审']}}, {{$newdata1['被退回']}}, {{$newdata1['审计中']}}, {{$newdata1['已出报告']}}]
           }]
       };

       var option3 = {
           title: {
               text: '结算审计项目情况统计'
           },
           tooltip: {},
           legend: {
               data:['项目数']
           },
           xAxis: {

               data: ["未送审","审计中","已完成"],

           },
           yAxis: {

           },
           series: [
             {
               name: '项目数',
               type: 'bar',
               barWidth: '50%',
               data: [{{$newdata3['未送审']}}, {{$newdata3['审计中']}}, {{$newdata3['已完成']}}]
           }]
       };



    var  option2 = {
    title: {
        text: '结算审计进度'
    },
    tooltip: {
        trigger: 'axis'
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
        data: ['周一','周二','周三','周四','周五','周六','周日']
    },
    yAxis: {
        type: 'value'
    },
    series: [
        {
            name:'完成审计订单数',
            type:'line',
            stack: '总量',
            data:[{{implode(",",$newdata2['ydata_ordernum'])}}]
        },
        {
            name:'完成审计项目数',
            type:'line',
            stack: '总量',
            data: [{{implode(",",$newdata2['ydata_projectnum'])}}]
        },

    ]
};

       // 使用刚指定的配置项和数据显示图表。
       myChart1.setOption(option1);
       myChart2.setOption(option2);
       myChart3.setOption(option3);
   </script>
@stop
