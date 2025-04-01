@component('mail::message')
# Reset Your Password

Click the button below to reset your password:

@component('mail::button', ['url' => route('userviewer.reset-password.form', ['token' => $token])])
Reset Password
@endcomponent

If you did not request this, please ignore this email.

Thanks,<br>
{{ config('app.name') }}
@endcomponent