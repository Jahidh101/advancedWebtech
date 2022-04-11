@extends('layouts/header')
@section('content')
<body>
<div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
                    @endif
                @endforeach
</div>
<form>
    @if(Session::get('userType') =='admin')
    <h1>User Info</h1>
    @else
    <h1>My profile</h1>
    @endif
    
    <img src="{{asset($info->profile_pic)}}" width="200px" height="200px"><br>
    <label><b>Username :</b></label><br>
    {{$info->username}}<br><br>

    <label><b>Full name :</b></label><br>
    {{$info->name}}<br><br>

    <label><b>Gender :</b></label><br>
    {{$info->gender}}<br><br>

    <label><b>User type :</b></label><br>
    {{$info->user_types->type}}<br><br>

    <label><b>Email :</b></label><br>
    {{$info->email}}<br><br>

    <label><b>Phone :</b></label><br>
    @if($info->phone == null)
    -<br><br>
    @else
    {{$info->phone}}<br><br>
    @endif

    <label><b>Address :</b></label><br>
    {{$info->address}}<br><br>

    @if(Session::get('username') == $info->username)
    <button><a href="{{route('user.profile.edit')}}">Edit profile</a></button><br>
    @endif
    


</form>
</body>
@endsection