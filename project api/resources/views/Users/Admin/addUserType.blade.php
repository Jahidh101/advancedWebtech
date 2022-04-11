@extends('layouts/header')
@section('content')
<body>
<form action="{{route('admin.addUserType.submit')}}" method="post">
    <h1>Add User type</h1>
    {{csrf_field()}}

    <label><b>User type</b></label><br>
    <input type="text" placeholder="Enter a user type" name="userType" ><br>
    @error('userType')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <button type="submit" vlaue="registration">Register</button><br>
</form>
</body>
@endsection
