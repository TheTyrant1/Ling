@component('mail::message')
    # Account Deactivation

    Hello {{ $userName }},

    Your account has been temporarily deactivated. You have **7 days** to restore your access before all data is permanently deleted.

    @component('mail::button', ['url' => $restoreUrl, 'color' => 'success'])
        Restore Account
    @endcomponent

    If you did not request this deletion, please click the button above to secure your account.

    Thanks,<br>
    WebLing
@endcomponent
