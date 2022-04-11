@extends('layouts/header')
@section('content')
<h1>Add profile picture</h1>
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
        @endif
    @endforeach
</div>
<form action="{{route('add.profile.picture')}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}

    <label><b>Select your picture :</b></label><br>
    <input type="file" name="profile_pic" ><br>
    @error('profile_pic')
    <span class=text-danger>{{$message}}</span><br>
    @enderror
    <br>
    
    <button type="submit" vlaue="registration">Submit</button><br>
</form>
@endsection