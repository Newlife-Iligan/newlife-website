<x-mail::message>
# Hello, {{ $member->first_name }}!

Your account has been created for **New Life - Iligan Dashboard**.

Here are your login credentials:

<x-mail::panel>
**Email:** {{ $user->email }}

**Password:** {{ $password }}
</x-mail::panel>

<x-mail::button :url="config('app.url')">
Login Now
</x-mail::button>

Please change your password after logging in for security purposes.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
