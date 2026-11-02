{{-- The order's PDF invoice (Order::invoicePdf, rendered by dompdf): tables and CSS 2.1 only.
     DejaVu Sans ships with dompdf and has the ₹ sign. --}}
@php
  use App\Models\Setting;
  $store = Setting::get('store_name');
@endphp
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Invoice {{ $order->invoiceNumber() }}</title>
<style>
  @page { margin: 0; }
  body { margin: 0; font-family: "DejaVu Sans", sans-serif; font-size: 10px; line-height: 1.5; color: #1f1830; }
  table { width: 100%; border-collapse: collapse; }
  td, th { vertical-align: top; }
  .band { background: #0b0b0b; color: #fff; padding: 30px 40px 26px; }
  .brand { font-size: 22px; font-weight: bold; letter-spacing: 3px; color: #f0cf8f; }
  .brand-sub { margin-top: 4px; font-size: 9px; color: #bdbdbd; }
  .title { font-size: 20px; font-weight: bold; letter-spacing: 4px; text-align: right; color: #fff; }
  .title-sub { margin-top: 4px; font-size: 9px; color: #bdbdbd; text-align: right; }
  .gold { height: 3px; background: #f0cf8f; }
  .body { padding: 28px 40px 0; }
  .label { font-size: 8px; font-weight: bold; letter-spacing: 1.5px; text-transform: uppercase; color: #8a8399; margin-bottom: 5px; }
  .meta { margin-bottom: 10px; }
  .meta td { padding: 0 0 12px; }
  .meta strong { font-size: 11px; }
  .box { padding: 12px 14px; border: 1px solid #e7e2f0; }
  .items { margin-top: 24px; }
  .items th { padding: 8px 10px; background: #f5f3fa; font-size: 8px; font-weight: bold; letter-spacing: 1.2px; text-transform: uppercase; color: #544b68; text-align: left; border-bottom: 1px solid #e7e2f0; }
  .items th.num { text-align: right; }
  .items td { padding: 10px; border-bottom: 1px solid #f1eef7; }
  .num { text-align: right; white-space: nowrap; }
  .muted { color: #8a8399; font-size: 8.5px; }
  .totals { width: 46%; margin: 16px 0 0 54%; }
  .totals td { padding: 5px 10px; }
  .totals .grand td { padding-top: 10px; border-top: 2px solid #1f1830; font-size: 13px; font-weight: bold; }
  .note { margin-top: 26px; padding: 12px 14px; background: #fbf3df; color: #554d43; }
  .foot { position: fixed; left: 40px; right: 40px; bottom: 26px; padding-top: 10px; border-top: 1px solid #e7e2f0; font-size: 8.5px; color: #8a8399; text-align: center; }
  .badge { display: inline-block; padding: 2px 8px; border-radius: 8px; font-size: 8px; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; }
  .badge-paid { background: #e7f2e9; color: #346a3e; }
  .badge-pending { background: #fbf0d9; color: #8a5f12; }
  .badge-refunded { background: #f9e6e9; color: #8e2e45; }
</style>
</head>
<body>

<div class="band">
  <table>
    <tr>
      <td>
        <div class="brand">{{ strtoupper($store) }}</div>
        <div class="brand-sub">{{ Setting::get('contact_email') }} &nbsp;·&nbsp; {{ Setting::get('contact_phone') }} &nbsp;·&nbsp; {{ preg_replace('#^https?://#', '', config('app.url')) }}</div>
      </td>
      <td>
        <div class="title">INVOICE</div>
        <div class="title-sub">{{ $order->invoiceNumber() }}</div>
      </td>
    </tr>
  </table>
</div>
<div class="gold"></div>

<div class="body">
  <table class="meta">
    <tr>
      <td style="width:25%"><div class="label">Invoice date</div><strong>{{ $order->created_at->format('d M Y') }}</strong></td>
      <td style="width:25%"><div class="label">Order number</div><strong>#{{ $order->number }}</strong></td>
      <td style="width:25%"><div class="label">Payment</div><strong>{{ $order->payment_label }}</strong></td>
      <td style="width:25%"><div class="label">Payment status</div><span class="badge badge-{{ $order->payment_status }}">{{ \App\Models\Order::PAYMENT_STATUSES[$order->payment_status] ?? $order->payment_status }}</span></td>
    </tr>
  </table>

  <table>
    <tr>
      <td style="width:49%" class="box">
        <div class="label">Billed to</div>
        <strong>{{ $order->customerName() }}</strong><br>
        {{ $order->email }}<br>
        {{ $order->phone }}
      </td>
      <td style="width:2%"></td>
      <td style="width:49%" class="box">
        <div class="label">Shipped to</div>
        <strong>{{ $order->customerName() }}</strong><br>
        {{ $order->address }}@if ($order->address_2), {{ $order->address_2 }}@endif<br>
        {{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}<br>
        {{ $order->country }}
      </td>
    </tr>
  </table>

  <table class="items">
    <thead>
      <tr><th style="width:5%">#</th><th>Item</th><th class="num" style="width:17%">Unit price</th><th class="num" style="width:8%">Qty</th><th class="num" style="width:18%">Amount</th></tr>
    </thead>
    <tbody>
      @foreach ($order->items as $i => $item)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{{ $item->name }}<br><span class="muted">Code: {{ $item->product_code }}</span></td>
          <td class="num">{{ inr($item->price) }}</td>
          <td class="num">{{ $item->qty }}</td>
          <td class="num">{{ inr($item->price * $item->qty) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <table class="totals">
    <tr><td>Subtotal</td><td class="num">{{ inr($order->subtotal) }}</td></tr>
    @if ((float) $order->discount)
      <tr><td>Discount ({{ $order->coupon_code }})</td><td class="num">− {{ inr($order->discount) }}</td></tr>
    @endif
    <tr><td>Shipping · {{ $order->shipping_label }}</td><td class="num">{{ (float) $order->shipping ? inr($order->shipping) : 'Free' }}</td></tr>
    <tr class="grand"><td>Total</td><td class="num">{{ inr($order->total) }}</td></tr>
    <tr><td colspan="2" class="muted num">All prices include tax.</td></tr>
  </table>

  @if ($order->note)
    <div class="note"><div class="label">Order instructions</div>{{ $order->note }}</div>
  @endif
</div>

<div class="foot">
  Thank you for shopping with {{ $store }}. Questions about this invoice? Write to {{ Setting::get('contact_email') }} or call {{ Setting::get('contact_phone') }}, quoting #{{ $order->number }}.
</div>

</body>
</html>
