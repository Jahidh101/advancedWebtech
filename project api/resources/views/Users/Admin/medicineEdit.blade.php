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
<form action="{{route('admin.medicine.edit')}}" method="post">
    <h1>Edit Medicine</h1>
    {{csrf_field()}}

    <input type="hidden" name="id" value="{{$medicine->id}}"><br>

    <label><b>Medicine Name :</b></label><br>
    <input type="text" placeholder="Enter Name" name="name" value="{{$medicine->name}}"><br>
    @error('name')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <label><b>Choose a medicine type :</b></label><br>
    <select name="medicineType">
        <option value="" disabled selected>Select a option</option>
        @foreach ($types as $t)
        @if($medicine->type == $t->id)
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
    <input type="text" placeholder="Enter weight per item" name="weight" value="{{$medicine->weight}}"><br>
    @error('weight')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <label><b>Quantity :</b></label><br>
    <input type="text" placeholder="Enter quantity" name="quantity" value="{{$medicine->quantity}}"><br><br>
    @error('quantity')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <input type="submit" class="btn btn-outline-primary" value="Update" name="submitbutton">
    <input type="submit" class="btn btn-outline-danger" value="OverWrite" name="submitbutton">

</form>
</body>
@endsection
