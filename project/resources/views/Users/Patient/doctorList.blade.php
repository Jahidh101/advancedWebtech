@extends('layouts/header')
@section('content')
<h1>Doctor list</h1>
<h3>Unread message from doctors</h3>
<div>
@if(!$unreadChat->count())
<h4 class="colorText">You have no unread text </h4>
@endif
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
<h3>Previous doctors</h3>
@if(!$readChat->count())
<h4 class="colorText">You have not contacted a doctor yet. </h4>
@endif
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
<div>
<h3>All doctors</h3>
        @foreach($infoAll as $info)
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
        @endforeach
</div>
@endsection