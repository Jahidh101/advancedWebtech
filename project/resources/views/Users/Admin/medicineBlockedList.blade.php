@extends('layouts/header')
@section('content')
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</a></p>
        @endif
    @endforeach
</div>

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
    @foreach($list as $li)
    <tr>
        <td>{{$li->id}}</td>
        <td>{{$li->name}}</td>
        <td>{{$li->medicine_types->type}}</td>
        <td>{{$li->weight}}</td>
        <td>{{$li->price_per_piece}}</td>
        <td>{{$li->quantity}}</td>
        <td><a class="btn btn-warning" href="{{route('admin.medicine.unblock',['id'=>$li->id])}}">Unblock</a></td> 
    </tr>
    @endforeach
</table>


@endsection