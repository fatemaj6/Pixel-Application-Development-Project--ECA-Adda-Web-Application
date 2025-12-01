<p>Hi {{ $user->name }},</p>
<p>We're sorry but your registration has been rejected.</p>
@if($refundInfo)
    <p>Refund status: {{ $refundInfo['status'] ?? 'unknown' }}</p>
    <p>Refund response: {{ $refundInfo['response'] ?? 'n/a' }}</p>
@endif
<p>Regards,<br>ECA Adda Team</p>
