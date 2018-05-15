@extends('layouts.default')
<style type="text/css">

     @media screen and (min-width: 992px) {
    #jumbotron1 {
        position:absolute;
        left:5px;
    }

    @media screen and (max-width: 992px) {
   #jumbotron1 {
       position:stsatic;
   }
}
 </style>
@section('title','主页')

@section('content')
<div class="jumbotron" style="position:relative">
  <div id="jumbotron1">
    <img src="/Uplouds/images/123.jpg" alt="微信公众号" class="img-rounded">
    <p class="lead">请扫码审计工程管理微信公众号</p>
  </div>
  <h1>您好，各位项目经理们</h1>
  <p class="lead">
    武汉移动工程建设部工程审计工作
  </p>
  <p>
    从现在开始，审计工作将变得无比轻松
  </p>
  <p>
    <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">现在注册</a>
  </p>
</div>
@stop
