@extends('layouts/header')
@section('content')
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</a></p>
        @endif
    @endforeach
</div>

<h1>Pending order List</h1>
<table class="table table-striped ">
    <tr>
        <th>Order Id</th>
        <th>Ordered Items</th>
        <th>Total price(with delivary)</th>
        <th>Delivary man username</th>
        <th>Status</th>
        <th></th>
    </tr>
    @foreach($data as $da)
    <tr>
        <td>{{$da['order_id']}}</td>

        <td>
            <ol>
            @foreach ($da['medicines'] as $med)
                <li>(Id :{{$med['medicine_id']}}) {{$med['name']}} {{$med['type']}} {{$med['weight']}} {{$med['quantity']}} piece = {{$med['price']}} taka</li>
            @endforeach
            </ol>
        </td>

        <td>{{$da['totalPrice']}}</td>
        <td>{{$da['delivary_username']}}</td>

        <td>
            @if ($da['status'] == 1)
                <p class="text-primary">Request pending</p>
            @elseif ($da['status'] == 3)
                <p class="text-warning">Waiting for delivary man</p>
            @elseif ($da['status'] == 5)
                <p class="text-info">On the way</p>
            @elseif ($da['status'] == 7)
                <p class="text-info">Complete</p>
            @elseif ($da['status'] == 0)
                <p class="text-danger">Cancelled</p>
            @elseif ($da['status'] == 9)
                <p class="text-success">Order received</p>
            @endif
        </td>

        <td> <a class="btn btn-success" href="{{route('seller.pending.order.accept', ['id' => $da['order_id']])}}">Accept</a> <a class="btn btn-danger" href="{{route('seller.pending.order.reject', ['id' => $da['order_id']])}}">Reject</a></td> 
    </tr>
    @endforeach
</table>
<br>


@endsection