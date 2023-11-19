@component('mail::message')
{{$data['Objet']}},

<p>Message:</p>
<div>{{$data['Message']}}</div>
<p>UserName: {{$data['UserName']}} $</p>
<p>Email: {{$data['email']}} </p>
<p>Phone Number: {{$data['PhoneNumber']}}</p>

Merci,<br>
{{ config('app.name') }}
@endcomponent