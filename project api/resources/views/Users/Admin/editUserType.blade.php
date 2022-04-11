@extends('layouts/header')
@section('content')
<body>
<form action="{{route('admin.UserType.edit.submit')}}" method="post">
    <h1>Edit User type</h1>
    {{csrf_field()}}

    <input type="hidden" name="id" value="{{$types->id}}"><br>

    <label><b>User type</b></label><br>
    <input type="text" placeholder="Enter a user type" name="userType" value="{{$types->type}}"><br>
    @error('userType')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <button type="submit" vlaue="registration">Register</button><br>
</form>
</body>
@endsection
