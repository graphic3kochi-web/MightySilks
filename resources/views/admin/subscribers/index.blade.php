@extends('layouts.admin')

@section('title', 'Subscribers')
@section('crumb', 'Subscribers')

@section('content')
<div class="adm-head">
  <div>
    <h1>Subscribers</h1>
    <p>{{ $total }} newsletter subscribers from the blog and sign-up</p>
  </div>
  <div class="adm-head__actions"><a class="adm-btn" href="{{ route('admin.subscribers.export') }}"><i class="fa-solid fa-file-csv"></i> Export CSV</a></div>
</div>

<section class="adm-card">
  <form class="adm-filters" method="get">
    <input type="search" name="q" value="{{ request('q') }}" placeholder="Email" aria-label="Search subscribers">
    <button class="adm-btn adm-btn--ghost" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
  </form>
  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Email</th><th>From</th><th>Subscribed</th><th></th></tr></thead>
      <tbody>
        @forelse ($subscribers as $subscriber)
          <tr>
            <td>{{ $subscriber->email }}</td>
            <td>{{ ucfirst($subscriber->source ?? '—') }}</td>
            <td>{{ $subscriber->created_at->format('d M Y') }}</td>
            <td><div class="adm-actions"><form method="post" action="{{ route('admin.subscribers.destroy', $subscriber) }}" data-confirm="Remove {{ $subscriber->email }}?">@csrf @method('delete')<button class="adm-btn adm-btn--danger adm-btn--sm" type="submit" aria-label="Remove"><i class="fa-solid fa-trash"></i></button></form></div></td>
          </tr>
        @empty
          <tr><td colspan="4" class="adm-empty">No subscribers found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $subscribers->links() }}
</section>
@endsection
