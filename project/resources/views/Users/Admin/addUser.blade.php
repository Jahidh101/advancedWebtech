@extends('layouts/header')
@section('content')
<body>
<form action="{{route('admin.addUser')}}" method="post">
    <h1>Add new user</h1>
    {{csrf_field()}}

    <label><b>Name</b></label><br>
    <input type="text" placeholder="Enter Name" name="name" value="{{old('name')}}"><br>
    @error('name')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <label><b>Choose a user type:</b></label><br>
    <select name="userTypes_id">
        <option value="" disabled selected>Select a option</option>
        @foreach ($types as $t)
        <option value="{{$t->id}}">{{$t->type}}</option>
        @endforeach
    </select> <br>
    @error('userTypes_id')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <label><b>Email</b></label><br>
    <input type="text" placeholder="Enter Email" name="email" value="{{old('email')}}"><br>
    @error('email')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <label><b>Phone</b></label><br>
    <input type="text" placeholder="Enter phone" name="phone" value="{{old('phone')}}"><br>
    @error('phone')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <label><b>Username</b></label><br>
    <input type="text" placeholder="Enter Username" name="username" value="{{old('username')}}"><br>
    @error('username')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <label><b>Password</b></label><br>
    <input type="password" placeholder="Enter Password" name="password"><br>
    @error('password')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <label><b>Confirm Password</b></label><br>
    <input type="password" placeholder="Confirm Password" name="confirmPassword"><br>
    @error('confirmPassword')
    <span class=text-danger>{{$message}}</span><br>
    @enderror
    <br>
    <button type="submit" vlaue="registration">Register</button><br>
</form>
</body>
@endsection