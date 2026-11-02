<div class="adm-table-wrap">
  <table class="adm-table">
    <thead>
      <tr><th>Order</th><th>Customer</th><th>Items</th><th>Status</th><th>Payment</th><th class="num">Total</th><th>Placed</th></tr>
    </thead>
    <tbody>
      @forelse ($orders as $order)
        <tr>
          <td><a href="{{ route('admin.orders.show', $order) }}">#{{ $order->number }}</a></td>
          <td>{{ $order->customerName() }}<br><span class="muted">{{ $order->email }}</span></td>
          <td>{{ $order->items_count }}</td>
          <td><span class="adm-badge adm-badge--{{ $order->status }}">{{ \App\Models\Order::STATUSES[$order->status] }}</span></td>
          <td><span class="adm-badge adm-badge--{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span><br><span class="muted">{{ $order->payment_label }}</span></td>
          <td class="num"><strong>{{ inr($order->total) }}</strong></td>
          <td><span title="{{ $order->created_at->format('d M Y H:i') }}">{{ $order->created_at->format('d M Y') }}</span><br><span class="muted">{{ $order->created_at->diffForHumans() }}</span></td>
        </tr>
      @empty
        <tr><td colspan="7" class="adm-empty">No orders found.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
