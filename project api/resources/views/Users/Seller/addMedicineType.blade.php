@extends('layouts/header')
@section('content')
<body>
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</a></p>
        @endif
    @endforeach
</div>
<form action="{{route('seller.medicineType.add')}}" method="post">
    <h1>Add Medicine Type</h1>
    {{csrf_field()}}

    <label><b>Medicine Type :</b></label><br>
    <input type="text" placeholder="Enter medicine type" name="type" value="{{old('type')}}"><br>
    @error('type')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <button type="submit" vlaue="registration">Add</button><br>
</form>
</body>
@endsection
