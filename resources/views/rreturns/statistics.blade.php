@extends('layouts.default')
<script type="text/javascript" src="/js/statistics.js"></script>

@section('title','关于')
@section('content')
<div class="col-md-2">
@include('layouts.left')
</div>
<div class="col-md-10">

      <div class="col-md-12" id="main1" style="height:500px;"></div>

</div>

<script type="text/javascript">
var data={!!$data!!};

if(!data.length){
  throw SyntaxError();
}
data['xaxis'].unshift('product');
data['data']['不具备决算送审条件'].unshift('不具备决算送审条件');
data['data']['具备送审条件未送审'].unshift('具备送审条件未送审');
data['data']['被退回'].unshift('被退回');
data['data']['审计中'].unshift('审计中');
data['data']['已出报告'].unshift('已出报告');
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
                data['data']['不具备决算送审条件'],
                data['data']['具备送审条件未送审'],
                data['data']['被退回'],
                data['data']['审计中'],
                data['data']['已出报告']
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




</script>
@stop
