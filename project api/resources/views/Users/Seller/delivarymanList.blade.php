@extends('layouts/header')
@section('content')
<h1>Delivaryman list</h1>

<table class="table table-striped">
    <tr>
        <th>Id</th>
        <th>Username</th>
        <th>Availaility</th>
        <th></th>
    </tr>
    @foreach($list as $li)
    <tr>
        <td>{{$li->id}}</td>
        <td>{{$li->username}}</td>
        <td>{{$li->availability}}</td>
        <form action="{{route('seller.delivaryman.status',['id'=>$li->id])}}" method="post">
            {{csrf_field()}}
        <td>
            <input class="btn btn-primary" type="submit" name= "status" value ="Assign">
            <input class="btn btn-primary" type="submit" name= "status" value ="Free">
        </td>
        </form>
    @endforeach
</table>
@endsection