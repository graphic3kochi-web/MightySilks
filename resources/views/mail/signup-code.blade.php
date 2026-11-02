{{-- Signup verification code email (App\Mail\SignupCode), in the order email's style. --}}
@php $store = \App\Models\Setting::get('store_name'); @endphp
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Your verification code</title></head>
<body style="margin:0; padding:0; background:#f5f3fa; font-family:Arial, Helvetica, sans-serif; color:#1f1830;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f5f3fa; padding:24px 12px;">
  <tr><td align="center">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:520px; background:#ffffff; border-radius:10px; overflow:hidden;">
      <tr><td style="background:#0b0b0b; padding:24px 28px; border-bottom:3px solid #f0cf8f;">
        <span style="font-size:20px; font-weight:bold; letter-spacing:3px; color:#f0cf8f;">{{ strtoupper($store) }}</span>
      </td></tr>
      <tr><td style="padding:28px;">
        <h1 style="margin:0 0 8px; font-size:22px; font-weight:normal;">Hi {{ $name }},</h1>
        <p style="margin:0; font-size:14px; line-height:1.6; color:#544b68;">Enter this code on the Create Account page to confirm your email and finish creating your {{ $store }} account.</p>
        <p style="margin:24px 0; padding:18px; background:#f5f3fa; border-radius:8px; text-align:center; font-size:32px; font-weight:bold; letter-spacing:10px; color:#1f1830;">{{ $code }}</p>
        <p style="margin:0; font-size:13px; line-height:1.6; color:#8a8399;">The code expires in 10 minutes. If you didn't try to create an account, you can ignore this email; no account is made without the code.</p>
      </td></tr>
    </table>
  </td></tr>
</table>
</body>
</html>
