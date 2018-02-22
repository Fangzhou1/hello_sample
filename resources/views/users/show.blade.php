@extends('layouts.default')

@section('title',$user->name)

@section('content')
<div class="row">

    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="media">
                    <div align="center">
                        <img class="thumbnail img-responsive" src="https://fsdhubcdn.phphub.org/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/600/h/600" width="300px" height="300px">
                    </div>
                    <div class="media-body">
                        <hr>
                        <h4><strong>个人简介</strong></h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                        <hr>
                        <h4><strong>注册于</strong></h4>
                        <p>January 01 1901</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
      <div class="panel panel-default">
<!-- Default panel contents -->
<div class="panel-heading">个人信息</div>

<ul class="list-group">
  <li class="list-group-item">用户名：{{$user->name}}</li>
  <li class="list-group-item">邮箱：{{$user->email}}</li>
  <li class="list-group-item">Morbi leo risus</li>
  <li class="list-group-item">Porta ac consectetur ac</li>
  <li class="list-group-item">Vestibulum at eros</li>
</ul>
</div>
        <hr>

        {{-- 用户发布的内容 --}}
        <div class="panel panel-default">
            <div class="panel-body">
                暂无数据 ~_~
            </div>
        </div>

    </div>
</div>
@stop
