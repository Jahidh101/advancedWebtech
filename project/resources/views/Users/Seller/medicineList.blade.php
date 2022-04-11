@extends('layouts/header')
@section('content')
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</a></p>
        @endif
    @endforeach
</div>

@if (Session::get('userType') == 'admin')     
<h1>New added medicine list</h1>
<table class="table table-striped ">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Type</th>
        <th>Weight</th>
        <th>Price per piece(Taka)</th>
        <th>Quantity</th>
        <th></th>
    </tr>
    @foreach($newList as $li)
    <tr>
        <td>{{$li->id}}</td>
        <td>{{$li->name}}</td>
        <td>{{$li->medicine_types->type}}</td>
        <td>{{$li->weight}}</td>
        <td>{{$li->price_per_piece}}</td>
        <td>{{$li->quantity}}</td>
        <td><a class="btn btn-primary" href="{{route('admin.medicine.edit',['id'=>$li->id])}}">Edit</a> <a class="btn btn-info" href="{{route('admin.medicine.price.set',['id'=>$li->id])}}">Set Price</a> <a class="btn btn-danger" href="{{route('admin.medicine.block',['id'=>$li->id])}}">Block</a></td> 
    </tr>
    @endforeach
</table>
@endif

<h1>Medicine list</h1>

<table class="table table-striped ">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Type</th>
        <th>Weight</th>
        <th>Price per piece(Taka)</th>
        @if (Session::get('userType') == 'admin' || Session::get('userType') == 'seller')
        <th>Quantity</th>
        @endif
        @if (Session::get('userType') == 'patient')
        <th>Order Quantity</th>
        @endif
        <th></th>
    </tr>
    @foreach($list as $li)
    <tr>
        <td>{{$li->id}}</td>
        <td>{{$li->name}}</td>
        <td>{{$li->medicine_types->type}}</td>
        <td>{{$li->weight}}</td>
        <td>{{$li->price_per_piece}}</td>
        @if (Session::get('userType') == 'admin' || Session::get('userType') == 'seller')
        <td>{{$li->quantity}}</td>
        @endif
        @if (Session::get('userType') == 'patient')
        <form action="{{route('patient.medicine.addToCart',['id'=>$li->id])}}" method="post">
            {{csrf_field()}}
            <td><input type="number" step="1" min="0" max="" name="quantity" value="0"  size="4"></td>
            <td><input class="btn btn-primary" type="submit" value ="Add to cart"></td>
        </form>
        @elseif (Session::get('userType') == 'admin')     
        <td><a class="btn btn-primary" href="{{route('admin.medicine.edit',['id'=>$li->id])}}">Edit</a> <a class="btn btn-info" href="{{route('admin.medicine.price.set',['id'=>$li->id])}}">Set Price</a> <a class="btn btn-danger" href="{{route('admin.medicine.block',['id'=>$li->id])}}">Block</a></td> 
        @endif 
    </tr>
    @endforeach
</table>
@endsection