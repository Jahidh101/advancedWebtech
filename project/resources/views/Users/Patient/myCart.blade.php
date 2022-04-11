@extends('layouts/header')
@section('content')
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</a></p>
        @endif
    @endforeach
</div>

<h1>My cart</h1>
@php
    $totalPrice = 0;
    $delivaryCost = 15;
@endphp
<table class="table table-striped ">
    <tr>
        <th>#</th>
        <th>Medicine Id</th>
        <th>Name</th>
        <th>Type</th>
        <th>Weight</th>
        <th>Quantity</th>
        <th>Price(Taka)</th>
        <th></th>
    </tr>
    @foreach($cart as $li)
    <tr>
        <td>{{$li->id}}</td>
        <td>{{$li->medicines_id}}</td>
        <td>{{$li->medicines->name}}</td>
        <td>{{$li->medicines->medicine_types->type}}</td>
        <td>{{$li->medicines->weight}}</td>
        <td>{{$li->quantity}}</td>
        <td>{{$li->price}}</td>
        @php
            $totalPrice = $totalPrice + $li->price;
        @endphp
        <td> <a class="btn btn-danger" href="{{route('patient.myCart.delete',['id'=>$li->id])}}">Remove from cart</a></td> 
    </tr>
    @endforeach
</table>
<br>
<div class="alignLeft paddingSide">
    Total price ={{$totalPrice + $delivaryCost}} taka  (medicine price {{$totalPrice}} taka + delivary price {{$delivaryCost}} taka)<br><br>
    <a class="btn btn-success" href="{{route('patient.myCart.confirm.order')}}">Confirm order</a>
</div>



@endsection