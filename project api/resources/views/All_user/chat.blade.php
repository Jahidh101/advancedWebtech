@extends('layouts/header')
@section('content')
<head></head>
<body>
<h1>Chatting</h1>
<b>Chatting with {{$receiverInfo->user_types->type}} {{$receiverInfo->name}} </b><br>
<br>
@foreach($chats as $chat)
<div class ="chatArea">
    @if($chat->sender == Session::get('username'))
    <div class="senderBackgroundColor">
        <div class="showChat-msg alignRight">
        {{$chat->message}}
        </div>

        <div class="showChat-name alignRight">
        : You
        </div>
    </div>
    @else
    <div class="receiverBackgroundColor">
        <div class="showChat-name">
        {{$chat->sender}} :
        </div>

        <div class="showChat-msg">
        {{$chat->message}} 
        </div>
    </div>
    @endif
</div>
@endforeach
<div><a href="{{route('doctor.chat.read',['receiverUsername'=> $receiverInfo->username])}}"><button>Read</button></a></div><br>

<form action="{{route('chat', ['receiverUsername'=>$receiverInfo->username])}}" method="post">
    {{csrf_field()}}

    <div>
    <textarea class="textareaSize" name="chatMsg"></textarea><br>
    </div>
    @error('chatMsg')
    <span class=text-danger>{{$message}}</span><br>
    @enderror
    <br>

    <div class ="chatArea alignRight"><button type="submit" vlaue="registration">Send</button></div><br>
    
</form>

</script>
</body>
@endsection
