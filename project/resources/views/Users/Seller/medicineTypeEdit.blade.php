@extends('layouts/header')
@section('content')
<body>
<form action="{{route('seller.medicineType.edit')}}" method="post">
    <h1>Edit Medicine type</h1>
    {{csrf_field()}}

    <input type="hidden" name="id" value="{{$types->id}}"><br>

    <label><b>Medicine type</b></label><br>
    <input type="text" placeholder="Enter a medicine type" name="type" value="{{$types->type}}"><br>
    @error('type')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <button type="submit" vlaue="registration">Confirm</button><br>
</form>
</body>
@endsection
