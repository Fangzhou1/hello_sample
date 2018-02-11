@extends('layouts.default')
@section('title', '所有用户')

@section('content')
<div class="col-md-offset-2 col-md-8">
  <h1>所有用户</h1>
  <ul class="users">
    @foreach ($users as $user)
      <li class=users-list>

        <a href="{{ route('users.show', $user->id )}}" class="username"> {{($users->currentPage()-1)*$page+$loop->iteration}}、{{ $user->name }}</a>
      @can('destroy', $user)
        <form class="pull-right" action="{{ route('users.destroy', $user->id) }}" method="post">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
          <button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>
        </form>
      @elsecannot('destroy', $user)
      <div class="pull-right">

        <span class="label label-info pull-right" style="height:39px;line-height:39px">管理员</span>

      </div>
      @endcan
      </li>
    @endforeach
  </ul>
  {!! $users->links() !!}
</div>
@stop
