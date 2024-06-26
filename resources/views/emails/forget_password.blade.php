{{-- @component('mail::message')

# Welcome to , {{ $user->name }}!

@component('mail::button', ['url' => url('reset-password/'. $user->remember_token)])
Change your password here
@endcomponent

<p>In case you have issues please contact our contact us.</p>
<p>Thank you</p>
Happy reading and writing!
@component('mail::button', ['url' => url('/')])
Visit Our Blog
@endcomponent
Best regards,<br>
{{ config('app.name') }} Team


@endcomponent --}}

@component('mail::message')

# Welcome, {{ $user->name }}!

Thank you for joining us! We are excited to have you as a part of our Blog.

@component('mail::button', ['url' => url('reset-password/' . $user->remember_token)])
Reset your password.
@endcomponent

<p>If you encounter any issues, please don't hesitate to <a href="mailto:support@example.com">contact us</a>.</p>

Thank you and happy reading and writing!

@component('mail::button', ['url' => url('/')])
Visit Our Blog
@endcomponent

Best regards,<br>
The {{ config('app.name') }} Team

@endcomponent