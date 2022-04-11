@extends('layouts/header')
@section('content')
<h1>User types list</h1>

<table border="1">
    <tr>
        <th>Id</th>
        <th>Type</th>
    </tr>
    @foreach($types as $t)
    <tr>
        <td>{{$t->id}}</td>
        <td>{{$t->type}}</td>
        <td><a class="btn btn-primary" href="{{route('admin.UserType.edit',['id'=>$t->id])}}">Edit</a></td>        
    </tr>
    @endforeach
</table>
@endsection