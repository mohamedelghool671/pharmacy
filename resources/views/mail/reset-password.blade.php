<x-mail::message>
Welcome {{ $user }}

<h1>Your password reset code is:</h1>============<span style="color: red;font-weight:900">{{ $code }}</span>============

<p>reset code will end after 5 minutes</p>



Thanks {{ $user }}<br>
</x-mail::message>
