@extends('layouts.admin')

@section('title', 'Enquiry from '.$enquiry->name)
@section('crumb', 'Enquiry')

@section('content')
<div class="adm-head">
  <div>
    <h1>{{ $enquiry->name }}</h1>
    <p>{{ $enquiry->type === 'contact' ? 'Contact page message' : ($enquiry->company ?: 'No company given') }} · received {{ $enquiry->created_at->format('d M Y, H:i') }}</p>
  </div>
  <div class="adm-head__actions">
    <a class="adm-btn" href="mailto:{{ $enquiry->email }}?subject={{ rawurlencode('Your '.\App\Models\Setting::get('store_name').' enquiry') }}"><i class="fa-solid fa-reply"></i> Reply by email</a>
  </div>
</div>

<div class="adm-detail">
  <section class="adm-card">
    <dl class="adm-dl">
      <dt>Email</dt><dd><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></dd>
      <dt>Phone</dt><dd>{{ $enquiry->phone ?: '—' }}</dd>
      @if ($enquiry->type === 'contact')
        <dt>Topic</dt><dd>{{ $enquiry->order_type }}</dd>
      @else
        <dt>Order type</dt><dd>{{ $enquiry->order_type }}</dd>
        <dt>Pieces</dt><dd>{{ $enquiry->quantity }}</dd>
        <dt>Budget per piece</dt><dd>{{ $enquiry->budget ?: '—' }}</dd>
        <dt>Needed by</dt><dd>{{ $enquiry->needed_by?->format('d M Y') ?? '—' }}</dd>
      @endif
    </dl>
    @if ($enquiry->message)
      <p class="dash-sublabel">Message</p>
      <p class="adm-prose">{{ $enquiry->message }}</p>
    @endif
  </section>
  <form class="adm-card" method="post" action="{{ route('admin.enquiries.update', $enquiry) }}">
    @csrf @method('put')
    <div class="adm-grid" style="grid-template-columns:1fr">
      <x-admin.field name="status" label="Status" :options="\App\Models\Enquiry::STATUSES" :value="$enquiry->status" />
    </div>
    <div class="adm-form__bar"><button class="adm-btn" type="submit">Save</button></div>
  </form>
</div>
@endsection
