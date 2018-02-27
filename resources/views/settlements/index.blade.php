@extends('layouts.default')
@section('title', '结算审计主页')

@section('content')

<div class="col-md-2">
@include('settlements.left')
</div>
<div class="col-md-10">


  <table class="table table-hover table-striped ">
        <thead>
          <tr>
            <th>{{ $settlements['title']->id }}</th>
            <th>{{ $settlements['title']->order_number }}</th>
            <th>{{ $settlements['title']->vendor_name }}</th>
            <th>{{ $settlements['title']->material_name }}</th>
            <th>{{ $settlements['title']->material_type }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($settlements['data'] as $data)
          <tr>
            <th scope="row">{{$data->id}}</th>
            <td>{{$data->order_number}}</td>
            <td>{{$data->vendor_name}}</td>
            <td>{{$data->material_name}}</td>
            <td>{{$data->material_type}}</td>
          </tr>
            @endforeach

        </tbody>
      </table>

      {!! $settlements['data']->links() !!}
</div>
@stop
