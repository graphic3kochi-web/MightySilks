@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@php
  $trend = fn ($t) => $t === null ? 'New' : ($t >= 0 ? '↗ +' : '↘ ').$t.'%';
  $trendClass = fn ($t) => $t === null ? '' : ($t >= 0 ? 'is-up' : 'is-down');
  $statusColors = ['placed' => '#b8862e', 'packed' => '#5a3596', 'shipped' => '#2f6f6a', 'delivered' => '#3f7a4a', 'cancelled' => '#8e2e45'];
  $pipelineTotal = max($statusCounts->sum(), 1);
  $categoryMax = max((float) $byCategory->max('revenue'), 1);
  $greeting = now()->hour < 12 ? 'Good morning' : (now()->hour < 17 ? 'Good afternoon' : 'Good evening');
  $toPack = $stats['awaiting']['placed'] + $stats['awaiting']['packed'];
@endphp

<section class="dash-greet">
  <div>
    <p class="dash-greet__date">{{ now()->format('l, d M Y') }}</p>
    <h1>{{ $greeting }}, {{ auth()->user()->name }}</h1>
    <p>In the last 30 days {{ \App\Models\Setting::get('store_name') }} took {{ $orders }} orders, gained {{ $newCustomers }} new customers and {{ $enquiries30 }} bulk enquiries.</p>
  </div>
  <div class="dash-greet__actions">
    @if ($waiting)
      <a class="adm-btn adm-btn--ghost" href="#attention"><i class="fa-solid fa-list-check"></i> Needs attention <b>{{ $waiting }}</b></a>
    @endif
    <a class="adm-btn adm-btn--gold" href="{{ route('admin.products.create') }}"><i class="fa-solid fa-plus"></i> Add Product</a>
  </div>
</section>

<div class="dash-kpis">
  <a class="dash-kpi" style="--tone:var(--gold-deep)" href="{{ route('admin.orders.index') }}">
    <div class="dash-kpi__top"><span class="dash-kpi__icon"><i class="fa-solid fa-indian-rupee-sign"></i></span><small>Revenue · 30d</small><span class="dash-kpi__trend {{ $trendClass($stats['revenue']['trend']) }}">{{ $trend($stats['revenue']['trend']) }}</span></div>
    <strong>{{ inr($stats['revenue']['total'], false) }}</strong>
    <span>Avg order {{ inr($stats['revenue']['average'], false) }} · {{ $paid }} paid orders</span>
    @include('admin.partials.spark', ['values' => $stats['revenue']['spark']])
  </a>
  <a class="dash-kpi" style="--tone:var(--purple-600)" href="{{ route('admin.orders.index') }}">
    <div class="dash-kpi__top"><span class="dash-kpi__icon"><i class="fa-solid fa-bag-shopping"></i></span><small>Orders · 30d</small><span class="dash-kpi__trend {{ $trendClass($stats['orders']['trend']) }}">{{ $trend($stats['orders']['trend']) }}</span></div>
    <strong>{{ number_format($stats['orders']['count']) }}</strong>
    <span>{{ $stats['orders']['delivered'] }} delivered · {{ $open }} in fulfilment</span>
    @include('admin.partials.spark', ['values' => $stats['orders']['spark']])
  </a>
  <a class="dash-kpi" style="--tone:var(--amber)" href="{{ route('admin.orders.index', ['status' => 'placed']) }}">
    <div class="dash-kpi__top"><span class="dash-kpi__icon"><i class="fa-solid fa-box"></i></span><small>Awaiting Dispatch</small><span class="dash-kpi__trend">Review</span></div>
    <strong>{{ $toPack }}</strong>
    <span>{{ $stats['awaiting']['placed'] }} to pack · {{ $stats['awaiting']['packed'] }} packed</span>
    <span class="dash-kpi__bar"><i style="width: {{ $toPack ? round($stats['awaiting']['packed'] / $toPack * 100) : 100 }}%"></i></span>
  </a>
  <a class="dash-kpi" style="--tone:var(--teal)" href="{{ route('admin.customers.index') }}">
    <div class="dash-kpi__top"><span class="dash-kpi__icon"><i class="fa-solid fa-users"></i></span><small>Customers</small><span class="dash-kpi__trend {{ $trendClass($stats['customers']['trend']) }}">{{ $trend($stats['customers']['trend']) }}</span></div>
    <strong>{{ number_format($stats['customers']['total']) }}</strong>
    <span>{{ $stats['customers']['new'] }} new · {{ $stats['customers']['blocked'] }} blocked</span>
    @include('admin.partials.spark', ['values' => $stats['customers']['spark']])
  </a>
</div>

<div class="dash-mid">
  <section class="adm-card dash-activity" data-views="activity">
    <div class="adm-card__head">
      <span class="adm-card__icon"><i class="fa-solid fa-chart-column"></i></span>
      <div>
        <h2 class="adm-card__title">Store Activity</h2>
        <p class="adm-card__sub">Orders, customer sign-ups and reviews per week, last {{ count($activity['labels']) }} weeks</p>
      </div>
      <div class="dash-legend" data-view-pane="chart">
        <span><i style="background:#3b1f6b"></i>Orders {{ array_sum($activity['orders']) }}</span>
        <span><i style="background:#d9b46a"></i>Sign-ups {{ array_sum($activity['signups']) }}</span>
        <span><i style="background:#a4507a"></i>Reviews {{ array_sum($activity['reviews']) }}</span>
      </div>
      <div class="adm-toggle" role="group" aria-label="Store activity view">
        <button type="button" aria-pressed="true" data-view="chart"><i class="fa-solid fa-chart-column"></i> Chart</button>
        <button type="button" aria-pressed="false" data-view="table"><i class="fa-solid fa-table-list"></i> Table</button>
      </div>
    </div>
    <div class="dash-chart" data-view-pane="chart"><canvas id="activity-chart" aria-label="Weekly store activity chart" role="img"></canvas></div>
    <div class="adm-table-wrap" data-view-pane="table" hidden>
      <table class="adm-table dash-table">
        <thead><tr><th>Week of</th><th class="num">Orders</th><th class="num">Sign-ups</th><th class="num">Reviews</th></tr></thead>
        <tbody>
          @foreach ($activity['labels'] as $i => $week)
            <tr><td>{{ $week }}</td><td class="num">{{ $activity['orders'][$i] }}</td><td class="num">{{ $activity['signups'][$i] }}</td><td class="num">{{ $activity['reviews'][$i] }}</td></tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr><td>Total</td><td class="num">{{ array_sum($activity['orders']) }}</td><td class="num">{{ array_sum($activity['signups']) }}</td><td class="num">{{ array_sum($activity['reviews']) }}</td></tr>
        </tfoot>
      </table>
    </div>
  </section>

  <section class="adm-card" id="attention">
    <div class="adm-card__head">
      <span class="adm-card__icon adm-card__icon--gold"><i class="fa-solid fa-list-check"></i></span>
      <div>
        <h2 class="adm-card__title">Needs Attention</h2>
        <p class="adm-card__sub">What's waiting on the team right now</p>
      </div>
    </div>
    @foreach ($attention as [$icon, $count, $label, $action, $url])
      <a class="dash-todo" href="{{ $url }}"><i class="fa-solid {{ $icon }}"></i><span><b>{{ $count }}</b> {{ $label }}</span><em>{{ $action }} ›</em></a>
    @endforeach
    <p class="dash-sublabel">Latest customers</p>
    @forelse ($latestCustomers as $customer)
      <a class="dash-person" href="{{ route('admin.customers.show', $customer) }}">
        <span class="adm-avatar">{{ $customer->initials() }}</span>
        <span><strong>{{ $customer->name }}</strong><small>Customer · signed up {{ $customer->created_at->diffForHumans() }}</small></span>
      </a>
    @empty
      <p class="muted">No customers yet.</p>
    @endforelse
  </section>
</div>

<section class="adm-card dash-orders">
  <div class="adm-card__head">
    <span class="adm-card__icon"><i class="fa-solid fa-receipt"></i></span>
    <div><h2 class="adm-card__title">Recent Orders</h2><p class="adm-card__sub">The latest orders across the store</p></div>
    <a class="adm-card__link" href="{{ route('admin.orders.index') }}">All orders →</a>
  </div>
  @include('admin.orders.table', ['orders' => $recentOrders])
</section>

<div class="dash-bottom">
  <section class="adm-card">
    <div class="adm-card__head">
      <span class="adm-card__icon adm-card__icon--teal"><i class="fa-solid fa-truck-fast"></i></span>
      <div><h2 class="adm-card__title">Order Pipeline</h2><p class="adm-card__sub">Every order by fulfilment status</p></div>
    </div>
    <div class="dash-pipe">
      @foreach (\App\Models\Order::STATUSES as $key => $label)
        <div style="--c: {{ $statusColors[$key] }}"><strong>{{ $statusCounts[$key] ?? 0 }}</strong><small>{{ $label }}</small></div>
      @endforeach
      <div style="--c: #1f1830"><strong>{{ $statusCounts->sum() }}</strong><small>All orders</small></div>
    </div>
    <div class="dash-stack" aria-hidden="true">
      @foreach ($statusColors as $key => $color)
        <i style="width: {{ ($statusCounts[$key] ?? 0) / $pipelineTotal * 100 }}%; background: {{ $color }}"></i>
      @endforeach
    </div>
  </section>

  <section class="adm-card" data-views="category">
    <div class="adm-card__head">
      <span class="adm-card__icon"><i class="fa-solid fa-tags"></i></span>
      <div><h2 class="adm-card__title">Sales by Category</h2><p class="adm-card__sub">Revenue in the last 90 days</p></div>
      @if ($byCategory->isNotEmpty())
        <div class="adm-toggle" role="group" aria-label="Sales by category view">
          <button type="button" aria-pressed="true" data-view="chart" aria-label="Chart"><i class="fa-solid fa-chart-bar"></i></button>
          <button type="button" aria-pressed="false" data-view="table" aria-label="Table"><i class="fa-solid fa-table-list"></i></button>
        </div>
      @endif
    </div>
    @forelse ($byCategory as $row)
      <div class="dash-row" data-view-pane="chart">
        <span>{{ \App\Models\Product::CATEGORIES[$row->category] ?? $row->category }}</span>
        <span class="dash-track"><i style="width: {{ $row->revenue / $categoryMax * 100 }}%"></i></span>
        <b>{{ inr($row->revenue, false) }}</b>
      </div>
    @empty
      <p class="muted">No sales in the last 90 days.</p>
    @endforelse
    @if ($byCategory->isNotEmpty())
      @php $categoryTotal = (float) $byCategory->sum('revenue'); @endphp
      <div class="adm-table-wrap" data-view-pane="table" hidden>
        <table class="adm-table dash-table">
          <thead><tr><th>Category</th><th class="num">Revenue</th><th class="num">Share</th></tr></thead>
          <tbody>
            @foreach ($byCategory as $row)
              <tr><td>{{ \App\Models\Product::CATEGORIES[$row->category] ?? $row->category }}</td><td class="num">{{ inr($row->revenue, false) }}</td><td class="num">{{ round($row->revenue / $categoryTotal * 100, 1) }}%</td></tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr><td>Total</td><td class="num">{{ inr($categoryTotal, false) }}</td><td class="num">100%</td></tr>
          </tfoot>
        </table>
      </div>
    @endif
  </section>

  <section class="adm-card">
    <div class="adm-card__head">
      <span class="adm-card__icon adm-card__icon--gold"><i class="fa-solid fa-wallet"></i></span>
      <div><h2 class="adm-card__title">Payment Methods</h2><p class="adm-card__sub">Orders in the last 90 days</p></div>
    </div>
    <div class="dash-donut"><canvas id="payment-chart" aria-label="Orders by payment method" role="img"></canvas></div>
  </section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
Chart.defaults.font.family = "'Roboto Web', system-ui, sans-serif"
Chart.defaults.color = '#8a8399'
const activity = @json($activity);
new Chart(document.getElementById('activity-chart'), {
  type: 'bar',
  data: {
    labels: activity.labels,
    datasets: [
      { label: 'Orders', data: activity.orders, backgroundColor: '#3b1f6b', borderRadius: 4, maxBarThickness: 14 },
      { label: 'Sign-ups', data: activity.signups, backgroundColor: '#d9b46a', borderRadius: 4, maxBarThickness: 14 },
      { label: 'Reviews', data: activity.reviews, backgroundColor: '#a4507a', borderRadius: 4, maxBarThickness: 14 },
    ],
  },
  options: {
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: { x: { grid: { display: false } }, y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f1eef7' }, border: { display: false } } },
  },
})
// Chart / Table switches ([data-views] cards), each remembered in this browser.
document.querySelectorAll('[data-views]').forEach((card) => {
  const key = `admin.view.${card.dataset.views}`
  const show = (view) => {
    card.querySelectorAll('[data-view-pane]').forEach((el) => { el.hidden = el.dataset.viewPane !== view })
    card.querySelectorAll('[data-view]').forEach((btn) => btn.setAttribute('aria-pressed', btn.dataset.view === view))
    try { localStorage.setItem(key, view) } catch (e) {}
  }
  card.querySelectorAll('[data-view]').forEach((btn) => btn.addEventListener('click', () => show(btn.dataset.view)))
  try { if (localStorage.getItem(key) === 'table') show('table') } catch (e) {}
})

const payments = @json($payments);
const PAYMENT_LABELS = { upi: 'UPI', card: 'Card', cod: 'Cash on Delivery' }
new Chart(document.getElementById('payment-chart'), {
  type: 'doughnut',
  data: {
    labels: Object.keys(payments).map((k) => PAYMENT_LABELS[k] || k),
    datasets: [{ data: Object.values(payments), backgroundColor: ['#3b1f6b', '#d9b46a', '#a4507a', '#2f6f6a'], borderWidth: 0 }],
  },
  options: { maintainAspectRatio: false, cutout: '68%', plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, usePointStyle: true } } } },
})
</script>
@endpush
