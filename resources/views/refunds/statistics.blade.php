@extends('layouts.default')
<script type="text/javascript" src="/js/statistics.js"></script>
@section('title','物资退库统计页')
@section('content')
<div class="col-md-2">
@include('layouts.left')
</div>
<div class="col-md-10">
  <div class="col-md-12" id="main1" style="height:500px;"></div>
</div>

<script type="text/javascript">

$(document).ready(function(){
window.Echo.channel('all')
    .listen('ChangeOrder', function(e){

      $("#totalcontainer").prepend('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+e.name+e.mes+e.order_number+'的订单</div>');

    });
  });

var data={!!$data!!};
console.log(data);
//  console.log(typeof data!='object');
if(typeof data!='object'){
  document.getElementById("main1").innerHTML="数据不存在！";
}
else
{
  data['xaxis'].unshift('product');
  data['data']['实物退库'].unshift('实物退库');
  data['data']['现金退库'].unshift('现金退库');
  data['data']['施工单位直接用于其它工程（有退库领用手续）'].unshift('施工单位直接用于其它工程（有退库领用手续）');
  data['data']['施工单位直接用于其它工程（无退库领用手续）'].unshift('施工单位直接用于其它工程（无退库领用手续）');
  data['data']['未退库金额'].unshift('未退库金额');
  console.log(data['xaxis']);
  console.log(data['data']);
  var myChart1 = echarts.init(document.getElementById('main1'));

  setTimeout(function () {

      option1 = {
          legend: {},
          tooltip: {
              trigger: 'axis',
              showContent: false
          },
          dataset: {
              source: [
                  data['xaxis'],
                  //['product',1,2,3,4,5,6,7],
                  data['data']['实物退库'],
                  data['data']['现金退库'],
                  data['data']['施工单位直接用于其它工程（有退库领用手续）'],
                  data['data']['施工单位直接用于其它工程（无退库领用手续）'],
                  data['data']['未退库金额']
              ]
          },
          xAxis: {type: 'category'},
          yAxis: {gridIndex: 0},
          grid: {top: '55%'},
          dataZoom: [
         {   // 这个dataZoom组件，默认控制x轴。
             type: 'slider', // 这个 dataZoom 组件是 slider 型 dataZoom 组件
             start: 0,      // 左边在 10% 的位置。
             end: 60         // 右边在 60% 的位置。
         }
     ],

          series: [
              {type: 'line', smooth: true, seriesLayoutBy: 'row'},
              {type: 'line', smooth: true, seriesLayoutBy: 'row'},
              {type: 'line', smooth: true, seriesLayoutBy: 'row'},
              {type: 'line', smooth: true, seriesLayoutBy: 'row'},
              {type: 'line', smooth: true, seriesLayoutBy: 'row'},
              {
                  type: 'pie',
                  id: 'pie',
                  radius: '30%',
                  center: ['50%', '25%'],
                  label: {
                      formatter: '{b}: {@'+data['xaxis'][1]+'} ({d}%)'
                  },
                  encode: {
                      itemName: 'product',
                      value: data['xaxis'][1],
                      tooltip: data['xaxis'][1]
                  }
              }
          ]
      };

      myChart1.on('updateAxisPointer', function (event) {
          var xAxisInfo = event.axesInfo[0];
          if (xAxisInfo) {
              var dimension = xAxisInfo.value + 1;
              myChart1.setOption({
                  series: {
                      id: 'pie',
                      label: {
                          formatter: '{b}: {@[' + dimension + ']} ({d}%)'
                      },
                      encode: {
                          value: dimension,
                          tooltip: dimension
                      }
                  }
              });
          }
      });

      myChart1.setOption(option1);
});


};




</script>
@stop
