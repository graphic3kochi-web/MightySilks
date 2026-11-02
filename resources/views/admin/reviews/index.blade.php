@extends('layouts.admin')

@section('title', 'Reviews')
@section('crumb', 'Reviews')

@section('content')
<div class="adm-head">
  <div>
    <h1>Reviews</h1>
    <p>Sent from product pages; approve the ones to keep</p>
  </div>
</div>

<section class="adm-card">
  <form class="adm-filters" method="get">
    <select name="status" aria-label="Status" onchange="this.form.submit()">
      <option value="">All reviews ({{ $counts->sum() }})</option>
      @foreach (\App\Models\Review::STATUSES as $key => $label)
        <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }} ({{ $counts[$key] ?? 0 }})</option>
      @endforeach
    </select>
  </form>
  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Review</th><th>Product</th><th>Rating</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse ($reviews as $review)
          <tr>
            <td style="min-width:260px; max-width:420px">
              <strong>{{ $review->title ?: 'Review' }}</strong> <span class="muted">by {{ $review->name }} · {{ $review->created_at->diffForHumans() }}</span>
              <p class="muted" style="margin-top:4px; color:var(--ink-2)">{{ $review->body }}</p>
            </td>
            <td>@if ($review->product)<a href="{{ url('product?p='.$review->product->code) }}" target="_blank" rel="noopener">{{ \Illuminate\Support\Str::limit($review->product->title, 40) }}</a>@else<span class="muted">Removed product</span>@endif</td>
            <td><span class="adm-stars" aria-label="{{ $review->rating }} of 5">{{ str_repeat('★', $review->rating) }}<span style="color:#e2dcec">{{ str_repeat('★', 5 - $review->rating) }}</span></span></td>
            <td><span class="adm-badge adm-badge--{{ $review->status }}">{{ \App\Models\Review::STATUSES[$review->status] }}</span></td>
            <td>
              <div class="adm-actions">
                @foreach (['approved' => ['Approve', 'fa-check'], 'rejected' => ['Reject', 'fa-xmark']] as $status => [$label, $icon])
                  @if ($review->status !== $status)
                    <form method="post" action="{{ route('admin.reviews.update', $review) }}">@csrf @method('put')<input type="hidden" name="status" value="{{ $status }}"><button class="adm-btn adm-btn--ghost adm-btn--sm" type="submit"><i class="fa-solid {{ $icon }}"></i> {{ $label }}</button></form>
                  @endif
                @endforeach
                <form method="post" action="{{ route('admin.reviews.destroy', $review) }}" data-confirm="Delete this review?">@csrf @method('delete')<button class="adm-btn adm-btn--danger adm-btn--sm" type="submit" aria-label="Delete"><i class="fa-solid fa-trash"></i></button></form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="adm-empty">No reviews here.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $reviews->links() }}
</section>
@endsection
