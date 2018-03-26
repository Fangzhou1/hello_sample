@extends('layouts.default')

@section('title','主页')

@section('content')
<div class="jumbotron">
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
