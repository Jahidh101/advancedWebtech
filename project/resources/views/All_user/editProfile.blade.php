@extends('layouts/header')
@section('content')
<body>

<form action="{{route('user.profile.edit')}}" method="post">
    <h1>Edit my profile</h1>
    {{csrf_field()}}

    <label><b>Name :</b></label><br>
    <input type="text" name="name" value={{$info->name}}><br><br>
    @error('name')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <label><b>Gender :</b></label><br>
    <?php $maleChecked = $femaleChecked = $otherChecked = '' ;?>
    @if($info->gender == 'male')
    <?php $maleChecked = 'checked'; ?>
    @elseif($info->gender == 'female')
    <?php $femaleChecked = 'checked'; ?>
    @else
    <?php $otherChecked = 'checked'; ?>
    @endif
    <input type="radio" id="male" name="gender" value="male" {{$maleChecked}}>
    <label for="male">Male</label>
    <input type="radio" id="female" name="gender" value="female" {{$femaleChecked}}>
    <label for="female">Female</label>  
    <input type="radio" id="other" name="gender" value="other" {{$otherChecked}}>
    <label for="other">Other</label><br><br>
    @error('gender')
    <span class=text-danger>{{$message}}</span><br>
    @enderror

    <label><b>Address :</b></label><br>
    <textarea name="address" rows="4" columns="50">{{$info->address}}</textarea><br><br>

    <br>
    <button type="submit" vlaue="registration">Update</button><br>
</form>
</body>
@endsection
