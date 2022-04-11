@extends('layouts/header')
@section('content')
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</a></p>
        @endif
    @endforeach
</div>

<h1>Accepted Order list</h1>
<table class="table table-striped ">
    <tr>
        <th>Order Id</th>
        <th>Ordered Items</th>
        <th>Total price with delivary(taka)</th>
        <th>Buyer Username and phone</th>
        <th>Address</th>
        <th>Ordered time</th>
        <th>Seller username</th>
        <th>Accepted/rejected at</th>
        <th>Delivary man username</th>
        <th>Delivary assigned at</th>
        <th>Delivary completed at</th>
        <th>Product received at</th>
        <th>Status</th>

        <th></th>
    </tr>
    @foreach($data as $da)
        @if ($da['status'] != 0 && $da['status'] != 9)
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
            <td>{{$da['username']}} {{$da['phone']}}</td>
            <td>{{$da['address']}}</td>
            <td>{{$da['orderedAt']}}</td>
            <td>{{$da['sellerUsername']}}</td>
            <td>{{$da['acceptedRejectedAt']}}</td>
            <td>{{$da['delivary_username']}}</td>
            <td>{{$da['delivaryAssignedAt']}}</td>
            <td>{{$da['delivaryCompletedAt']}}</td>
            <td>{{$da['productReceivedAt']}}</td>

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

            <form action="{{route('seller.delivaryman.assign',['id'=>$da['order_id']])}}" method="post">
            {{csrf_field()}}
            <td>
            <input type="text" name="delivary_username" value="{{$da['delivary_username']}}" size="4"> <br><br>
            @error('delivary_username')
            <span class=text-danger>{{$message}}</span><br>
            @enderror
            <input class="btn btn-primary" type="submit" value ="Assign delivaryman">
            </td>
            </form>
        </tr>
        @endif
    @endforeach
</table>
<br>


@endsection