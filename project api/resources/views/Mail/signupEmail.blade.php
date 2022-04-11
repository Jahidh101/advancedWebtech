Hello {{$email_data['name']}}<br>

Welcome to my website<br>

Please click the following link to verify your email and activate your account<br>

<a href="{{route('verify.email',['verification_code'=>$email_data['verification_code']])}}">Click here</a><br>

Thank you.
<br>
Online Pharmacy.