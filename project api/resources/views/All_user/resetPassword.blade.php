@extends('layouts/header')
@section('content')
<body>

<form action="{{route('reset.password',['verification_code'=>$verification_code])}}" method="post">
    <h1>Reset password</h1>
    {{csrf_field()}}

    <label><b>New password :</b></label><br>
    <input type="password" name="password" placeholder="Enter new password"><br>
    @error('password')
    <span class=text-danger>{{$message}}</span><br>
    @enderror
    <br>

    <label><b>Confirm password :</b></label><br>
    <input type="password" name="confirmPassword" placeholder="Re-type new password"><br>
    @error('confirmPassword')
    <span class=text-danger>{{$message}}</span><br>
    @enderror
    <br>


    <button type="submit" vlaue="registration">Update</button><br>
</form>
</body>
@endsection
