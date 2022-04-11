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
<form action="{{route('admin.medicine.price.set')}}" method="post">
    <h1>Edit Medicine</h1>
    {{csrf_field()}}

    <input type="hidden" name="id" value="{{$medicine->id}}"><br>

    <label><b>Medicine Name :</b></label><br>
    <input type="text" name="name" value="{{$medicine->name}}" disabled><br>

    <label><b>Choose a medicine type :</b></label><br>
    <input type="text" name="type" value="{{$medicine->medicine_types->type}}" disabled><br>

    <label><b>Weight :</b></label><br>
    <input type="text"  name="weight" value="{{$medicine->weight}}" disabled><br>

    <label><b>Peice per piece :</b></label><br>
    <input type="text" placeholder="Enter price per piece" name="pricePerPiece" value="{{$medicine->price_per_piece}}"><br><br>
    @error('pricePerPiece')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <input type="submit" class="btn btn-outline-primary" value="Update" name="submitbutton">

</form>
</body>
@endsection
