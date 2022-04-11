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
<form action="{{route('forgot.password')}}" method="post">
    <h1>Forgot password</h1>
    {{csrf_field()}}

    <label><b>Please enter your username :</b></label><br>
    <input type="text" placeholder="Enter a username" name="username"><br>
    @error('username')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <button type="submit" vlaue="registration">Submit</button><br>
</form>
</body>
@endsection
