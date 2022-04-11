@extends('layouts/header')
@section('content')
<h1>Patient list</h1>
<h3>Unread message from patients</h3>
<div>
    @foreach($unreadChat as $unread)
        @foreach($infoAll as $info)
            @if($unread == $info->username)
                <div class="some-class divBorder">
                    <form>
                        <img src="{{asset($info->profile_pic)}}" width="100px" height="100px"><br>
                        <label><b>Username :</b></label>
                        {{$info->username}}<br>

                        <label><b>Full name :</b></label>
                        {{$info->name}}<br>

                        <label><b>Gender :</b></label>
                        {{$info->gender}}<br>

                        <label><b>Email :</b></label>
                        {{$info->email}}<br>

                        <label><b>Phone :</b></label>
                        @if($info->phone == null)
                        -<br>
                        @else
                        {{$info->phone}}<br>
                        @endif

                        <label><b>Address :</b></label>
                        {{$info->address}}<br>

                        <a href="{{route('chat', ['receiverUsername'=>$info->username])}}"><button type="button" class="btn btn-info">Chat*</button></a><br>
                    </form>
                </div>
            @endif
        @endforeach
    @endforeach
</div>

<div>
<h3>Previous patients</h3>

@foreach($readChat as $read)
        @foreach($infoAll as $info)
            @if($read == $info->username)
                <div class="some-class divBorder">
                    <form>
                        <img src="{{asset($info->profile_pic)}}" width="100px" height="100px"><br>
                        <label><b>Username :</b></label>
                        {{$info->username}}<br>

                        <label><b>Full name :</b></label>
                        {{$info->name}}<br>

                        <label><b>Gender :</b></label>
                        {{$info->gender}}<br>

                        <label><b>Email :</b></label>
                        {{$info->email}}<br>

                        <label><b>Phone :</b></label>
                        @if($info->phone == null)
                        -<br>
                        @else
                        {{$info->phone}}<br>
                        @endif

                        <label><b>Address :</b></label>
                        {{$info->address}}<br>

                        <a href="{{route('chat', ['receiverUsername'=>$info->username])}}"><button type="button" class="btn btn-info">Chat</button></a><br>
                    </form>
                </div>
            @endif
        @endforeach
    @endforeach
</div>
@endsection