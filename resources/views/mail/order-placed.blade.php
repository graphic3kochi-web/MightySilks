{{-- Order confirmation email (App\Mail\OrderPlaced). Table layout with inline styles, for mail clients. --}}
@php $store = \App\Models\Setting::get('store_name'); @endphp
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Order #{{ $order->number }}</title></head>
<body style="margin:0; padding:0; background:#f5f3fa; font-family:Arial, Helvetica, sans-serif; color:#1f1830;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f5f3fa; padding:24px 12px;">
  <tr><td align="center">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; background:#ffffff; border-radius:10px; overflow:hidden;">
      <tr><td style="background:#0b0b0b; padding:24px 28px; border-bottom:3px solid #f0cf8f;">
        <span style="font-size:20px; font-weight:bold; letter-spacing:3px; color:#f0cf8f;">{{ strtoupper($store) }}</span>
      </td></tr>

      <tr><td style="padding:28px 28px 8px;">
        <h1 style="margin:0 0 8px; font-size:22px; font-weight:normal;">Thank you, {{ $order->first_name }}!</h1>
        <p style="margin:0; font-size:14px; line-height:1.6; color:#544b68;">We've received your order <strong style="color:#1f1830;">#{{ $order->number }}</strong>, placed on {{ $order->created_at->format('d M Y') }}. We'll pack it within 48 business hours and email you when it ships.</p>
        <p style="margin:12px 0 0; font-size:14px; line-height:1.6; color:#544b68;">Your invoice <strong style="color:#1f1830;">{{ $order->invoiceNumber() }}</strong> is attached to this email as a PDF.</p>
      </td></tr>

      <tr><td style="padding:16px 28px 0;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:13px;">
          @foreach ($order->items as $item)
            <tr>
              <td style="padding:10px 0; border-bottom:1px solid #f1eef7;">{{ $item->name }}<br><span style="color:#8a8399; font-size:12px;">{{ inr($item->price) }} × {{ $item->qty }}</span></td>
              <td align="right" style="padding:10px 0; border-bottom:1px solid #f1eef7; white-space:nowrap;">{{ inr($item->price * $item->qty) }}</td>
            </tr>
          @endforeach
          <tr><td style="padding:10px 0 4px; color:#544b68;">Subtotal</td><td align="right" style="padding:10px 0 4px;">{{ inr($order->subtotal) }}</td></tr>
          @if ((float) $order->discount)
            <tr><td style="padding:4px 0; color:#544b68;">Discount ({{ $order->coupon_code }})</td><td align="right" style="padding:4px 0;">− {{ inr($order->discount) }}</td></tr>
          @endif
          <tr><td style="padding:4px 0; color:#544b68;">Shipping · {{ $order->shipping_label }}</td><td align="right" style="padding:4px 0;">{{ (float) $order->shipping ? inr($order->shipping) : 'Free' }}</td></tr>
          <tr><td style="padding:12px 0 0; border-top:2px solid #1f1830; font-size:16px; font-weight:bold;">Total</td><td align="right" style="padding:12px 0 0; border-top:2px solid #1f1830; font-size:16px; font-weight:bold;">{{ inr($order->total) }}</td></tr>
        </table>
      </td></tr>

      <tr><td style="padding:24px 28px;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:13px; line-height:1.6; color:#544b68;">
          <tr>
            <td width="50%" valign="top"><strong style="color:#1f1830;">Shipping to</strong><br>{{ $order->customerName() }}<br>{{ $order->address }}@if ($order->address_2), {{ $order->address_2 }}@endif<br>{{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}<br>{{ $order->country }}</td>
            <td width="50%" valign="top"><strong style="color:#1f1830;">Payment</strong><br>{{ $order->payment_label }}</td>
          </tr>
        </table>
      </td></tr>

      <tr><td align="center" style="padding:0 28px 28px;">
        <a href="{{ url('order-details?order='.$order->number) }}" style="display:inline-block; padding:12px 28px; background:#0b0b0b; color:#f0cf8f; text-decoration:none; font-size:14px; border-radius:6px;">View your order</a>
      </td></tr>

      <tr><td style="padding:18px 28px; background:#f5f3fa; font-size:12px; line-height:1.6; color:#8a8399; text-align:center;">
        Questions? Reply to this email, write to {{ \App\Models\Setting::get('contact_email') }} or call {{ \App\Models\Setting::get('contact_phone') }}.
      </td></tr>
    </table>
  </td></tr>
</table>
</body>
</html>
