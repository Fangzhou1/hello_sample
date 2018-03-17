@extends('layouts.default')
<script type="text/javascript" src="/js/statistics.js"></script>

@section('title','关于')
@section('content')
<div class="col-md-2">
@include('layouts.left')
</div>
<div class="col-md-10">

      <div class="col-md-12" id="main1" style="height:400px;"></div>
      <div class="col-md-12" id="main2" style="height:800px;"></div>

</div>

<script type="text/javascript">
var myChart1 = echarts.init(document.getElementById('main1'));
var myChart2 = echarts.init(document.getElementById('main2'));
var  option1 = {
title: {
    text: '可进入决算审计状态项目进度'
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
myChart1.setOption(option1);

setTimeout(function () {

    option2 = {
        legend: {},
        tooltip: {
            trigger: 'axis',
            showContent: false
        },
        dataset: {
            source: [
                ['product', '2012', '2013', '2014', '2015', '2016', '2017'],
                ['Matcha Latte', 41.1, 30.4, 65.1, 53.3, 83.8, 98.7],
                ['Milk Tea', 86.5, 92.1, 85.7, 83.1, 73.4, 55.1],
                ['Cheese Cocoa', 24.1, 67.2, 79.5, 86.4, 65.2, 82.5],
                ['Walnut Brownie', 55.2, 67.1, 69.2, 72.4, 53.9, 39.1]
            ]
        },
        xAxis: {type: 'category'},
        yAxis: {gridIndex: 0},
        grid: {top: '55%'},
        series: [
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
                    formatter: '{b}: {@2012} ({d}%)'
                },
                encode: {
                    itemName: 'product',
                    value: '2012',
                    tooltip: '2012'
                }
            }
        ]
    };

    myChart2.on('updateAxisPointer', function (event) {
        var xAxisInfo = event.axesInfo[0];
        if (xAxisInfo) {
            var dimension = xAxisInfo.value + 1;
            myChart2.setOption({
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

    myChart2.setOption(option2);

});




</script>
@stop
