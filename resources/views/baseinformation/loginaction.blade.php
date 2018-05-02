@extends('layouts.default')
<style type="text/css">

     @media screen and (min-width: 992px) {
    .table-responsive {
        height:400px;
    }
}
 </style>
<script type="text/javascript" src="/js/statistics.js"></script>
@section('title','登录及操作')
@section('content')

<div class="col-md-12">
  <div class="row">
  <div class="col-md-3">


    请选择年月：<select id="select1" name='yearandmonth' class="form-control">
      @foreach ($datas0 as $data0)
    <option  {{$click_yearandmonth==$data0?'selected':''}} value='{{$data0}}'>{{$data0}}</option>
      @endforeach
    </select>


  </div>

  <div class="col-md-9">

  </div>
  </div>

  <div class="row">
    <div class="col-md-12 page-header" style="margin-top: 0px;">
      <h1><small><b>项目经理登录统计</b></small></h1>
    </div>
  </div>

  <div class="row">
  <div class="col-md-6">
    <div class="table-responsive">
    <table class="table table-striped table-condensed">
      <thead>
        <tr>
          <th>名字</th>
          <th>登录次数</th>
          <th>详情</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($datas1['datas'] as $data1)
        <tr>
          <td>{{$data1['name']}}</td>
          <td>{{$data1['loginnum']}}</td>
          <td><button type="button" class="btn btn-default" aria-label="Left Align" data-toggle="modal" data-target="#exampleModal" data-whatever1="{{json_encode($data1['loginrecords'])}}" data-whatever2={{$data1['name']}} data-whatever3=1>
  <span title='详情' class="glyphicon glyphicon-align-left" aria-hidden="true"></span>
</button></td>
        </tr>
        @endforeach
        @foreach ($datas1['datas_supplements'] as $datas1_supplement)
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






        <div class="row">
          <div class="col-md-12 page-header" style="margin-top: 0px;">
            <h1><small><b>项目经理操作数据统计</b></small></h1>
          </div>
        </div>

        <div class="row">
        <div class="col-md-6">
          <div class="table-responsive">
          <table class="table table-striped table-condensed">
            <thead>
              <tr>
                <th>名字</th>
                <th>操作数据次数</th>
                <th>详情</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($datas4['datas'] as $data4)
              <tr>
                <td>{{$data4['name']}}</td>
                <td>{{$data4['actionnum']}}</td>
                <td><button type="button" class="btn btn-default" aria-label="Left Align" data-toggle="modal" data-target="#exampleModal" data-whatever1="{{json_encode($data4['actionrecords'])}}" data-whatever2={{$data4['name']}} data-whatever3=2>
        <span title='详情' class="glyphicon glyphicon-align-left" aria-hidden="true"></span>
      </button></td>
              </tr>
              @endforeach
              @foreach ($datas4['datas_supplements'] as $datas4_supplement)
              <tr>
                <td>{{$datas4_supplement}}</td>
                <td>0</td>
                <td>/</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          </div>
          </div>
          <div class="col-md-6">
            <div class="col-md-12" id="main2" style="height:400px;"></div>
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

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">确定</button>
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
  var recipient1 = button.data('whatever1'); // Extract info from data-* attributes
  var recipient2 = button.data('whatever2');
  var recipient3 = button.data('whatever3');
  //alert(typeof(recipient1));
  var modal = $(this);
  if(recipient3==1)
    modal.find('.modal-title').text(recipient2+'的登录详情');
  else if(recipient3==2)
    modal.find('.modal-title').text(recipient2+'的操作数据详情');
  recipient1="<p>"+recipient1.join("</p><p>")+"</p>";
  //console.log(recipient1);
  modal.find('.modal-body').html(recipient1);
})



$("#select1").change(function(){
  //alert('aa');
  var name=$("#select1").attr("name");
  var nameval=$("#select1").val();
  window.location.href="{{route('baseinformation.loginaction')}}?"+name+'='+nameval

})



       // 基于准备好的dom，初始化echarts实例
       var myChart1 = echarts.init(document.getElementById('main1'));
       var myChart2 = echarts.init(document.getElementById('main2'));


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



    var  option2 = {
    title: {
        text: '用户操作数据统计({{$datas5['title']}})'
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

        data:['用户操作数据总数']
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
        data: {!!$datas5['x']!!}

    },
    yAxis: {
        type: 'value'
    },
    series: [
        {
            name:'完成审计订单数',
            type:'line',
            data:{{$datas5['y']}}
          }
    ]
};

       // 使用刚指定的配置项和数据显示图表。
       myChart1.setOption(option1);
       myChart2.setOption(option2);


   </script>
@stop
