@extends('layouts/header')
@section('content')
<h1>Admin Homepage</h1>
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
        @endif
    @endforeach
</div>

<h4>Your website is running smoothly!!!</h4><br><br>

<h3>Total verified users :</h3>
<h2>{{$data['allVerifiedUsers']}}</h2><br>

<h3>Total verified doctors :</h3>
<h2>{{$data['verifiedDoctors']}}</h2><br>

<h3>Total verified patients :</h3>
<h2>{{$data['verifiedPatients']}}</h2><br>
@endsection