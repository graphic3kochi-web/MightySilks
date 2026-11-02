@extends('layouts.admin')

@section('title', 'Enquiries')
@section('crumb', 'Enquiries')

@section('content')
<div class="adm-head">
  <div>
    <h1>Enquiries</h1>
    <p>Corporate &amp; bulk orders from the Corporate page, and messages from the Contact page</p>
  </div>
</div>

<section class="adm-card">
  <form class="adm-filters" method="get">
    <select name="status" aria-label="Status" onchange="this.form.submit()">
      <option value="">All enquiries ({{ $counts->sum() }})</option>
      @foreach (\App\Models\Enquiry::STATUSES as $key => $label)
        <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }} ({{ $counts[$key] ?? 0 }})</option>
      @endforeach
    </select>
  </form>
  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>From</th><th>Order type / topic</th><th class="num">Pieces</th><th>Budget</th><th>Status</th><th>Received</th></tr></thead>
      <tbody>
        @forelse ($enquiries as $enquiry)
          <tr>
            <td><a href="{{ route('admin.enquiries.show', $enquiry) }}">{{ $enquiry->name }}</a>@if ($enquiry->company)<br><span class="muted">{{ $enquiry->company }}</span>@endif</td>
            <td>@if ($enquiry->type === 'contact')<span class="muted">Contact ·</span> @endif{{ $enquiry->order_type }}</td>
            <td class="num">{{ $enquiry->quantity ?? '—' }}</td>
            <td>{{ $enquiry->budget ?: '—' }}</td>
            <td><span class="adm-badge adm-badge--{{ $enquiry->status }}">{{ \App\Models\Enquiry::STATUSES[$enquiry->status] }}</span></td>
            <td>{{ $enquiry->created_at->format('d M Y') }}</td>
          </tr>
        @empty
          <tr><td colspan="6" class="adm-empty">No enquiries here.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $enquiries->links() }}
</section>
@endsection
