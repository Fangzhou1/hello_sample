@extends('layouts.default')

@section('title','主页')

@section('content')
<div class="jumbotron">
  <h1>Hello，朋友 </h1>
  <p class="lead">
    武汉移动工程建设部工程审计工作
  </p>
  <p>
    一切，将从这里开始。
  </p>
  <p>
    <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">现在注册</a>
  </p>
</div>
@stop
