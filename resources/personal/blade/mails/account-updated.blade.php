@component('mail::message')
    # Account updated

    Hi {{ $user->name }},

    You requested to update your account. If this was you, no action is required.

    If you did **not** request this update, please change your password immediately.

    Thanks,<br>
    WebLing
@endcomponent
