@extends('layouts/header')
@section('content')
<body>
<div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    @endif
                @endforeach
            </div>
<form action="{{route('register')}}" method="post">
    <h1>Add new user</h1>
    {{csrf_field()}}

    <label><b>Name :</b></label><br>
    <input type="text" placeholder="Enter Name" name="name" value="{{old('name')}}"><br>
    @error('name')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <label><b>Gender :</b></label><br>
    <input type="radio" id="male" name="gender" value="male">
    <label for="male">Male</label>
    <input type="radio" id="female" name="gender" value="female">
    <label for="female">Female</label>  
    <input type="radio" id="other" name="gender" value="other">
    <label for="other">Other</label><br>
    @error('gender')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    @if(Session::get('userType') == 'admin')
    <label><b>Choose a user type :</b></label><br>
    <select name="userTypes_id">
        <option value="" disabled selected>Select a option</option>
        @foreach ($types as $t)
        <option value="{{$t->id}}">{{$t->type}}</option>
        @endforeach
    </select> <br>
    @error('userTypes_id')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    @else
    <label><b>User type :</b></label><br>
    <select name="userTypes_id">
        <option value="{{$types->id}}">{{$types->type}}</option>
    </select> <br>
    @error('userTypes_id')
    <span class=text-danger>{{$message}}</span><br>
    @enderror
    @endif

    <label><b>Email :</b></label><br>
    <input type="text" placeholder="Enter Email" name="email" value="{{old('email')}}"><br>
    @error('email')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <label><b>Address :</b></label><br>
    <textarea name="address" rows="4" columns="50"></textarea><br>

    <label><b>Username :</b></label><br>
    <input type="text" placeholder="Enter Username" name="username" value="{{old('username')}}"><br>
    @error('username')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <label><b>Password :</b></label><br>
    <input type="password" placeholder="Enter Password" name="password"><br>
    @error('password')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <label><b>Confirm Password :</b></label><br>
    <input type="password" placeholder="Confirm Password" name="confirmPassword"><br>
    @error('confirmPassword')
    <span class=text-danger>{{$message}}</span><br>
    @enderror
    <br>
    <button type="submit" vlaue="registration">Register</button><br>
</form>
</body>
@endsection
