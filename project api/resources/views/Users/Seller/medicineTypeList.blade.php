@extends('layouts/header')
@section('content')
<h1>Medicine types list</h1>

<table class="table table-striped">
    <tr>
        <th>Id</th>
        <th>Type</th>
        <th></th>
    </tr>
    @foreach($types as $t)
    <tr>
        <td>{{$t->id}}</td>
        <td>{{$t->type}}</td>
        <td><a class="btn btn-primary" href="{{route('seller.medicineType.edit',['id'=>$t->id])}}">Edit</a></td>        
    </tr>
    @endforeach
</table>
@endsection