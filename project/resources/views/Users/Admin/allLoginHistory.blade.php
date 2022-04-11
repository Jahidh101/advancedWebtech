@extends('layouts/header')
@section('content')
<h1>All login history</h1>

<table border="1">
    <tr>
        <th>Id</th>
        <th>Log</th>
        <th>Time</th>
    </tr>
    @foreach($list as $li)
    <tr>
        <td>{{$li->id}}</td>
        <td>Username <a href="{{route('user.personal.info',['username'=>encrypt($li->username)])}}">{{$li->username}}</a>({{$li->all_users->user_types->type}}) has logged in.</td>
        <td>{{$li->login_time}}</td>
    </tr>
    @endforeach
</table>
@endsection
