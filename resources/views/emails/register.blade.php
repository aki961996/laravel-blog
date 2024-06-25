@component('mail::message')

# Welcome to {{ config('app.name') }}, {{ $user->name }}!

Thank you for registering on our blog. We're excited to have you join our community.

@component('mail::button', ['url' => url('/')])
Visit Our Blog
@endcomponent

Happy reading and writing!

Best regards,<br>
{{ config('app.name') }} Team


@endcomponent