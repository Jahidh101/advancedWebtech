@extends('layouts/header')
@section('content')
<body>
<form action="{{route('admin.addDelivaryman')}}" method="post">
    <h1>Add delivary man</h1>
    {{csrf_field()}}

    <label><b>Username</b></label><br>
    <input type="text" placeholder="Enter a user name" name="username" ><br>
    @error('username')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <button type="submit" vlaue="registration">Add</button><br>
</form>
</body>
@endsection
