@extends('layouts/header')
@section('content')
<html>
<div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
                    @endif
                @endforeach
            </div>
<form action="{{route('loginUser')}}" method="post">
    {{Session::get('msg')}}
    <h1>Login</h1>
    {{csrf_field()}}

    <label><b>Username</b></label><br>
    <input type="text" placeholder="Enter Username" name="username"><br>
    @error('username')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <label><b>Password</b></label><br>
    <input type="password" placeholder="Enter Password" name="password"><br>

    <button type="submit">Login</button><br>

    <a href="{{route('forgot.password')}}">Forgot your password?</a>

</form> 
</html>
@endsection