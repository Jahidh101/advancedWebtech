Hello {{$email_data['name']}}<br>

Welcome to my website<br>

Please click the following link to reset your password<br>

<a href="{{route('reset.password',['verification_code'=>$email_data['verification_code']])}}">Click here</a><br>

Thank you.
<br>
Online Pharmacy.