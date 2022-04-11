@extends('layouts/header')
@section('content')
<h1>Delivaryman list</h1>

<table class="table table-striped">
    <tr>
        <th>Id</th>
        <th>Username</th>
        <th>Availaility</th>
    </tr>
    @foreach($list as $li)
    <tr>
        <td>{{$li->id}}</td>
        <td>{{$li->username}}</td>
        <td>{{$li->availability}}</td>
    @endforeach
</table>
@endsection