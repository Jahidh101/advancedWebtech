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
<form action="" method="post">
    <h1>Add Medicine</h1>
    {{csrf_field()}}

    <label><b>Medicine Name :</b></label><br>
    <input type="text" placeholder="Enter Name" name="name" value="{{old('name')}}"><br>
    @error('name')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <label><b>Choose a medicine type :</b></label><br>
    <select name="medicineType">
        <option value="" disabled selected>Select a option</option>
        @foreach ($types as $t)
        @if(old('medicineType') == $t->id)
        <option value="{{$t->id}}" selected>{{$t->type}}</option>
        @else
        <option value="{{$t->id}}">{{$t->type}}</option>
        @endif
        @endforeach
    </select> <br>
    @error('medicineType')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <label><b>Weight :</b></label><br>
    <input type="text" placeholder="Enter weight per item" name="weight" value="{{old('weight')}}">
    <select name="unit">
        <option value="" disabled selected>Select a Unit</option>
        <option value ="mg">mg</option>
        <option value ="ml">ml</option>
    </select><br>
    @error('weight')
    <span class=text-danger>{{$message}}</span>
    @enderror
    @error('unit')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <label><b>Quantity :</b></label><br>
    <input type="text" placeholder="Enter quantity" name="quantity" value="{{old('quantity')}}"><br>
    @error('quantity')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <button type="submit" vlaue="registration">ADD</button><br>
</form>
</body>
@endsection
